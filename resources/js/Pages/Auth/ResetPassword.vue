<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import AuthenticationLayout from '@/Layouts/AuthenticationLayout.vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import { Input } from '@/Components/shadcn/ui/input/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'

const props = defineProps({
	email: String,
	token: String,
})

const form = useForm({
	token: props.token,
	email: props.email,
	password: '',
	password_confirmation: '',
})

const submit = () => {
	form.post(route('password.update'), {
		onFinish: () => form.reset('password', 'password_confirmation'),
	})
}
</script>

<template>
	<Head title="Reset Password" />

	<AuthenticationLayout>
		<template #logo>
			<div class="mb-5">
				<span class="sr-only">Home</span>
				<ApplicationLogo class="size-16 fill-background stroke-primary" />
			</div>
		</template>

		<form @submit.prevent="submit" class="space-y-4">
			<div>
				<Label for="email">Email</Label>
				<Input
					v-model="form.email"
					type="email"
					placeholder="Email"
					id="email" />
				<InputError class="mt-2" :message="form.errors.email" />
			</div>

			<div>
				<Label for="password">Password</Label>
				<Input
					v-model="form.password"
					type="password"
					placeholder="Password"
					id="password" />
				<InputError class="mt-2" :message="form.errors.password" />
			</div>

			<div>
				<Label for="password_confirmation">Confirm Password</Label>
				<Input
					v-model="form.password_confirmation"
					type="password"
					placeholder="Confirm Password"
					id="password_confirmation" />
				<InputError class="mt-2" :message="form.errors.password_confirmation" />
			</div>

			<div class="flex items-center justify-end">
				<Button :disabled="form.processing">Reset Password</Button>
			</div>
		</form>
	</AuthenticationLayout>
</template>
