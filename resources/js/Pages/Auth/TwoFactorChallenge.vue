<script setup>
import { nextTick, ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import AuthenticationLayout from '@/Layouts/AuthenticationLayout.vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import { CardDescription } from '@/Components/shadcn/ui/card/index.js'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import { Input } from '@/Components/shadcn/ui/input/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'

const recovery = ref(false)

const form = useForm({
	code: '',
	recovery_code: '',
})

const recoveryCodeInput = ref(null)
const codeInput = ref(null)

const toggleRecovery = async () => {
	recovery.value ^= true

	await nextTick()

	if (recovery.value) {
		recoveryCodeInput.value.focus()
		form.code = ''
	} else {
		codeInput.value.focus()
		form.recovery_code = ''
	}
}

const submit = () => {
	form.post(route('two-factor.login'))
}
</script>

<template>
	<Head title="Two-factor Confirmation" />

	<AuthenticationLayout>
		<template #logo>
			<Link
				:href="route('landing')"
				class="mb-5 rounded outline-none focus-visible:ring-2 focus-visible:ring-primary">
				<span class="sr-only">Home</span>
				<ApplicationLogo class="size-16 fill-background stroke-primary" />
			</Link>
		</template>

		<CardDescription class="my-4">
			<template v-if="!recovery">
				Please confirm access to your account by entering the authentication
				code provided by your authenticator application.
			</template>

			<template v-else>
				Please confirm access to your account by entering one of your emergency
				recovery codes.
			</template>
		</CardDescription>

		<form @submit.prevent="submit" class="space-y-4">
			<div v-if="!recovery">
				<Label for="code">Code</Label>
				<Input v-model="form.code" type="text" placeholder="Code" id="code" />
				<InputError class="mt-2" :message="form.errors.code" />
			</div>

			<div v-else>
				<Label for="recovery_code">Recovery Code</Label>
				<Input
					v-model="form.recovery_code"
					type="text"
					placeholder="Recovery Code"
					id="recovery_code" />
				<InputError class="mt-2" :message="form.errors.recovery_code" />
			</div>

			<div class="flex items-center justify-end">
				<Button variant="link" type="button" @click.prevent="toggleRecovery">
					<template v-if="!recovery"> Use a recovery code</template>

					<template v-else> Use an authentication code</template>
				</Button>

				<Button :disabled="form.processing">Log in</Button>
			</div>
		</form>
	</AuthenticationLayout>
</template>
