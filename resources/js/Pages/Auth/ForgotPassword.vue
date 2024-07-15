<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import { Head, useForm } from '@inertiajs/vue3'

defineProps<{
	status?: string
}>()

const form = useForm({
	email: '',
})

const submit = () => {
	form.post(route('password.email'))
}
</script>

<template>
	<GuestLayout>
		<Head title="Forgot Password" />

		<Card class="w-full max-w-md">
			<template #subtitle>
				Forgot your password? No problem. Just let us know your email address
				and we will email you a password reset link that will allow you to
				choose a new one.
			</template>

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

					<div class="flex justify-end">
						<Button
							type="submit"
							:disabled="form.processing"
							label="Email Password Reset Link" />
					</div>
				</form>
			</template>
		</Card>
	</GuestLayout>
</template>
