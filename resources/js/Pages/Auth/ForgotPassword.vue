<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import AuthenticationLayout from '@/Layouts/AuthenticationLayout.vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import { CardDescription } from '@/Components/shadcn/ui/card/index.js'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import { Input } from '@/Components/shadcn/ui/input/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'

defineProps({
	status: String,
})

const form = useForm({
	email: '',
})

const submit = () => {
	form.post(route('password.email'))
}
</script>

<template>
	<Head title="Forgot Password" />

	<AuthenticationLayout>
		<template #logo>
			<Link
				:href="route('landing')"
				class="mb-5 rounded outline-none focus-visible:ring-2 focus-visible:ring-primary">
				<span class="sr-only">Home</span>
				<ApplicationLogo class="size-16 fill-background stroke-primary" />
			</Link>
		</template>

		<div v-if="status" class="mb-4 text-sm font-medium text-foreground">
			{{ status }}
		</div>

		<CardDescription class="my-4">
			Forgot your password? No problem. Just let us know your email address and
			we will email you a password reset link that will allow you to choose a
			new one.
		</CardDescription>

		<form @submit.prevent="submit" class="space-y-4">
			<div>
				<Label for="email">Email</Label>
				<Input
					type="email"
					placeholder="Email"
					id="email"
					v-model="form.email" />
				<InputError class="mt-2" :message="form.errors.email" />
			</div>

			<div class="flex items-center justify-end">
				<Button type="submit" :disabled="form.processing">
					Email Password Reset Link
				</Button>
			</div>
		</form>
	</AuthenticationLayout>
</template>
