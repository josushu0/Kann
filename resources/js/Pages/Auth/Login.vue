<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import AuthenticationLayout from '@/Layouts/AuthenticationLayout.vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import { Input } from '@/Components/shadcn/ui/input/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'
import { Checkbox } from '@/Components/shadcn/ui/checkbox/index.js'

defineProps({
	canResetPassword: Boolean,
	status: String,
})

const form = useForm({
	email: '',
	password: '',
	remember: false,
})

const submit = () => {
	form
		.transform((data) => ({
			...data,
			remember: form.remember ? 'on' : '',
		}))
		.post(route('login'), {
			onFinish: () => form.reset('password'),
		})
}
</script>

<template>
	<Head title="Log in" />

	<AuthenticationLayout>
		<template #logo>
			<Link :href="route('landing')">
				<ApplicationLogo class="mb-5 size-16 fill-background stroke-primary" />
			</Link>
		</template>

		<div v-if="status" class="mb-4 text-sm font-medium text-foreground">
			{{ status }}
		</div>

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

			<div>
				<div class="flex items-center justify-between">
					<Label for="password">Password</Label>
					<Button v-if="canResetPassword" variant="link" as-child>
						<Link :href="route('password.request')">Forgot your password?</Link>
					</Button>
				</div>
				<Input
					type="password"
					placeholder="Password"
					id="password"
					v-model="form.password" />
				<InputError class="mt-2" :message="form.errors.password" />
			</div>

			<div class="flex items-center gap-2">
				<Checkbox v-model:checked="form.remember" id="remember" />
				<Label for="remember">Remember me</Label>
			</div>

			<div class="mt-4 flex items-center justify-end">
				<Button v-if="canResetPassword" variant="link" as-child>
					<Link :href="route('register')">Don't have an account?</Link>
				</Button>

				<Button type="submit" :disabled="form.processing">Login</Button>
			</div>
		</form>
	</AuthenticationLayout>
</template>
