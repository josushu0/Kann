<script setup>
import { computed, ref, watch } from 'vue'
import { router, useForm, usePage } from '@inertiajs/vue3'
import ConfirmsPassword from '@/Components/ConfirmsPassword.vue'
import InputError from '@/Components/InputError.vue'
import {
	Card,
	CardContent,
	CardDescription,
	CardTitle,
} from '@/Components/shadcn/ui/card/index.js'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import { Input } from '@/Components/shadcn/ui/input/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'

const props = defineProps({
	requiresConfirmation: Boolean,
})

const page = usePage()
const enabling = ref(false)
const confirming = ref(false)
const disabling = ref(false)
const qrCode = ref(null)
const setupKey = ref(null)
const recoveryCodes = ref([])

const confirmationForm = useForm({
	code: '',
})

const twoFactorEnabled = computed(
	() => !enabling.value && page.props.auth.user?.two_factor_enabled
)

watch(twoFactorEnabled, () => {
	if (!twoFactorEnabled.value) {
		confirmationForm.reset()
		confirmationForm.clearErrors()
	}
})

const enableTwoFactorAuthentication = () => {
	enabling.value = true

	router.post(
		route('two-factor.enable'),
		{},
		{
			preserveScroll: true,
			onSuccess: () =>
				Promise.all([showQrCode(), showSetupKey(), showRecoveryCodes()]),
			onFinish: () => {
				enabling.value = false
				confirming.value = props.requiresConfirmation
			},
		}
	)
}

const showQrCode = () => {
	return axios.get(route('two-factor.qr-code')).then((response) => {
		qrCode.value = response.data.svg
	})
}

const showSetupKey = () => {
	return axios.get(route('two-factor.secret-key')).then((response) => {
		setupKey.value = response.data.secretKey
	})
}

const showRecoveryCodes = () => {
	return axios.get(route('two-factor.recovery-codes')).then((response) => {
		recoveryCodes.value = response.data
	})
}

const confirmTwoFactorAuthentication = () => {
	confirmationForm.post(route('two-factor.confirm'), {
		errorBag: 'confirmTwoFactorAuthentication',
		preserveScroll: true,
		preserveState: true,
		onSuccess: () => {
			confirming.value = false
			qrCode.value = null
			setupKey.value = null
		},
	})
}

const regenerateRecoveryCodes = () => {
	axios.post(route('two-factor.recovery-codes')).then(() => showRecoveryCodes())
}

const disableTwoFactorAuthentication = () => {
	disabling.value = true

	router.delete(route('two-factor.disable'), {
		preserveScroll: true,
		onSuccess: () => {
			disabling.value = false
			confirming.value = false
		},
	})
}
</script>

<template>
	<div class="grid gap-4 md:grid-cols-3">
		<div>
			<h2 class="font-bold">Two Factor Authentication</h2>
			<p class="text-sm">
				Add additional security to your account using two factor authentication.
			</p>
		</div>

		<Card class="col-span-2">
			<CardContent class="mt-6 space-y-4">
				<CardTitle v-if="twoFactorEnabled && !confirming" class="text-lg">
					You have enabled two factor authentication.
				</CardTitle>
				<CardTitle v-else-if="twoFactorEnabled && confirming" class="text-lg">
					Finish enabling two factor authentication.
				</CardTitle>
				<CardTitle v-else class="text-lg">
					You have not enabled two factor authentication.
				</CardTitle>
				<CardDescription>
					When two factor authentication is enabled, you will be prompted for a
					secure, random token during authentication. You may retrieve this
					token from your phone's Google Authenticator application.
				</CardDescription>
				<div v-if="twoFactorEnabled" class="space-y-4">
					<div v-if="qrCode" class="space-y-4">
						<p v-if="confirming" class="text-sm font-bold">
							To finish enabling two factor authentication, scan the following
							QR code using your phone's authenticator application or enter the
							setup key and provide the generated OTP code.
						</p>

						<p v-else class="text-sm font-bold">
							Two factor authentication is now enabled. Scan the following QR
							code using your phone's authenticator application or enter the
							setup key.
						</p>

						<div v-html="qrCode" class="dark:invert" />

						<p v-if="setupKey" class="text-sm font-bold">
							Setup Key: <span v-html="setupKey" />
						</p>

						<div>
							<Label for="code">Code</Label>
							<Input
								type="text"
								inputmode="numeric"
								id="code"
								name="code"
								@keyup.enter="confirmTwoFactorAuthentication"
								v-model="confirmationForm.code" />
							<InputError
								:message="confirmationForm.errors.code"
								class="mt-2" />
						</div>
					</div>

					<div v-if="recoveryCodes.length > 0 && !confirming" class="space-y-4">
						<p class="text-sm font-bold">
							Store these recovery codes in a secure password manager. They can
							be used to recover access to your account if your two factor
							authentication device is lost.
						</p>
						<div class="space-y-1 rounded bg-muted p-4 font-mono text-sm">
							<div v-for="code in recoveryCodes" :key="code">
								{{ code }}
							</div>
						</div>
					</div>
				</div>

				<div>
					<ConfirmsPassword
						v-if="!twoFactorEnabled"
						@confirmed="enableTwoFactorAuthentication">
						<Button :disabled="enabling">Enable</Button>
					</ConfirmsPassword>

					<div v-else class="space-x-1">
						<ConfirmsPassword @confirmed="confirmTwoFactorAuthentication">
							<Button v-if="confirming" :disabled="enabling">Confirm</Button>
						</ConfirmsPassword>

						<ConfirmsPassword @confirmed="regenerateRecoveryCodes">
							<Button
								v-if="recoveryCodes.length > 0 && !confirming"
								variant="outline">
								Regenerate Recovery Codes
							</Button>
						</ConfirmsPassword>

						<ConfirmsPassword @confirmed="showRecoveryCodes">
							<Button
								v-if="recoveryCodes.length === 0 && !confirming"
								variant="outline">
								Show Recovery Codes
							</Button>
						</ConfirmsPassword>

						<ConfirmsPassword @confirmed="disableTwoFactorAuthentication">
							<Button v-if="confirming" variant="outline" :disabled="disabling">
								Cancel
							</Button>
						</ConfirmsPassword>

						<ConfirmsPassword @confirmed="disableTwoFactorAuthentication">
							<Button
								v-if="!confirming"
								variant="destructive"
								:disabled="disabling">
								Disable
							</Button>
						</ConfirmsPassword>
					</div>
				</div>
			</CardContent>
		</Card>
	</div>
</template>
