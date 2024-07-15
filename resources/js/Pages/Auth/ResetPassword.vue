<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import { Head, useForm } from '@inertiajs/vue3'

const props = defineProps<{
	email: string
	token: string
}>()

const form = useForm({
	token: props.token,
	email: props.email,
	password: '',
	password_confirmation: '',
})

const submit = () => {
	form.post(route('password.store'), {
		onFinish: () => {
			form.reset('password', 'password_confirmation')
		},
	})
}
</script>

<template>
	<GuestLayout>
		<Head title="Reset Password" />

		<Card class="w-full max-w-md">
			<template #content>
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

					<div class="flex flex-col">
						<label for="password_confirmation" class="text-sm">
							Confirm Password
						</label>

						<Password
							id="password_confirmation"
							name="password_confirmation"
							v-model="form.password_confirmation"
							:invalid="form.errors.password_confirmation ? true : false"
							toggle-mask
							:feedback="false"
							:pt="{ pcInput: { root: { class: 'w-full' } } }"
							required />

						<InputError :message="form.errors.password_confirmation" />
					</div>

					<div class="flex justify-end">
						<Button
							type="submit"
							:disabled="form.processing"
							label="Reset Password" />
					</div>
				</form>
			</template>
		</Card>
	</GuestLayout>
</template>
