<script setup lang="ts">
import InputError from '@/Components/InputError.vue'
import GuestLayout from '@/Layouts/GuestLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

defineProps<{
	canResetPassword?: boolean
	status?: string
}>()

const form = useForm({
	email: '',
	password: '',
	remember: false,
})

const submit = () => {
	form.post(route('login'), {
		onFinish: () => {
			form.reset('password')
		},
	})
}
</script>

<template>
	<GuestLayout>
		<Head title="Log in" />
		<Card class="w-full max-w-md">
			<template #content>
				<div v-if="status" class="mb-4 text-sm font-medium text-emerald-500">
					{{ status }}
				</div>

				<form @submit.prevent="submit" class="space-y-4 text-color">
					<div class="flex flex-col">
						<label for="email" class="text-sm">Email</label>

						<InputText
							id="email"
							name="email"
							type="email"
							v-model="form.email"
							:invalid="form.errors.email ? true : false"
							required
							autofocus />

						<InputError :message="form.errors.email" />
					</div>

					<div class="flex flex-col">
						<label for="password" class="text-sm">Password</label>

						<Password
							id="password"
							name="password"
							v-model="form.password"
							:invalid="form.errors.password ? true : false"
							toggle-mask
							:feedback="false"
							:pt="{ pcInput: { root: { class: 'w-full' } } }"
							required />

						<InputError :message="form.errors.password" />
					</div>

					<div>
						<label class="flex items-center gap-2">
							<Checkbox name="remember" v-model="form.remember" binary />
							<span class="text-sm">Remember me</span>
						</label>
					</div>

					<div class="flex items-center justify-end gap-4">
						<Link
							v-if="canResetPassword"
							:href="route('password.request')"
							class="text-sm outline-1 outline-offset-4 rounded-border text-muted-color focus:outline focus:outline-primary">
							Forgot your Password?
						</Link>

						<Button :disabled="form.processing" type="submit" label="Log in" />
					</div>
				</form>
			</template>
		</Card>
	</GuestLayout>
</template>
