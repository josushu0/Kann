<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import AuthenticationLayout from '@/Layouts/AuthenticationLayout.vue'
import { Button } from '@/Components/shadcn/ui/button/index.js'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import { Input } from '@/Components/shadcn/ui/input/index.js'

const form = useForm({
	name: '',
	email: '',
	password: '',
	password_confirmation: '',
	terms: false,
})

const submit = () => {
	form.post(route('register'), {
		onFinish: () => form.reset('password', 'password_confirmation'),
	})
}
</script>

<template>
	<Head title="Register" />

	<AuthenticationLayout>
		<template #logo>
			<div class="mb-5">
				<span class="sr-only">Home</span>
				<ApplicationLogo class="size-16 fill-background stroke-primary" />
			</div>
		</template>

		<form @submit.prevent="submit" class="space-y-4">
			<div>
				<Label for="Name">Name</Label>
				<Input v-model="form.name" type="text" placeholder="Name" id="name" />
				<InputError class="mt-2" :message="form.errors.name" />
			</div>

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

			<!--      Terms of service-->
			<!--			<div-->
			<!--				v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature"-->
			<!--				class="mt-4">-->
			<!--				<InputLabel for="terms">-->
			<!--					<div class="flex items-center">-->
			<!--						<Checkbox-->
			<!--							id="terms"-->
			<!--							v-model:checked="form.terms"-->
			<!--							name="terms"-->
			<!--							required />-->

			<!--						<div class="ms-2">-->
			<!--							I agree to the-->
			<!--							<a-->
			<!--								target="_blank"-->
			<!--								:href="route('terms.show')"-->
			<!--								class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"-->
			<!--								>Terms of Service</a-->
			<!--							>-->
			<!--							and-->
			<!--							<a-->
			<!--								target="_blank"-->
			<!--								:href="route('policy.show')"-->
			<!--								class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"-->
			<!--								>Privacy Policy</a-->
			<!--							>-->
			<!--						</div>-->
			<!--					</div>-->
			<!--					<InputError class="mt-2" :message="form.errors.terms" />-->
			<!--				</InputLabel>-->
			<!--			</div>-->

			<div class="flex items-center justify-end">
				<Button variant="link" as-child>
					<Link :href="route('login')">Already registered?</Link>
				</Button>

				<Button :disabled="form.processing">Register</Button>
			</div>
		</form>
	</AuthenticationLayout>
</template>
