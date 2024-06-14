<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import AuthenticationLayout from '@/Layouts/AuthenticationLayout.vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import { CardDescription } from '@/Components/shadcn/ui/card/index.js'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import { Input } from '@/Components/shadcn/ui/input/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'

const form = useForm({
	password: '',
})

const passwordInput = ref(null)

const submit = () => {
	form.post(route('password.confirm'), {
		onFinish: () => {
			form.reset()

			passwordInput.value.focus()
		},
	})
}
</script>

<template>
	<Head title="Secure Area" />

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
			This is a secure area of the application. Please confirm your password
			before continuing.
		</CardDescription>

		<form @submit.prevent="submit" class="space-y-4">
			<div>
				<Label for="password">Password</Label>
				<Input
					v-model="form.password"
					ref="passwordInput"
					type="password"
					placeholder="Password"
					id="password" />
				<InputError class="mt-2" :message="form.errors.password" />
			</div>

			<div class="flex justify-end">
				<Button :disabled="form.processing">Confirm</Button>
			</div>
		</form>
	</AuthenticationLayout>
</template>
