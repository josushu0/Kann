<script setup>
import { computed } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import AuthenticationLayout from '@/Layouts/AuthenticationLayout.vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import { CardDescription } from '@/Components/shadcn/ui/card/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'

const props = defineProps({
	status: String,
})

const form = useForm({})

const submit = () => {
	form.post(route('verification.send'))
}

const verificationLinkSent = computed(
	() => props.status === 'verification-link-sent'
)
</script>

<template>
	<Head title="Email Verification" />

	<AuthenticationLayout>
		<template #logo>
			<Link
				:href="route('landing')"
				class="mb-5 rounded outline-none focus-visible:ring-2 focus-visible:ring-primary">
				<span class="sr-only">Home</span>
				<ApplicationLogo class="size-16 fill-background stroke-primary" />
			</Link>
		</template>

		<CardDescription class="space-y-4">
			<p>
				Before continuing, could you verify your email address by clicking on
				the link we just emailed to you? If you didn't receive the email, we
				will gladly send you another.
			</p>
			<p v-if="verificationLinkSent">
				A new verification link has been sent to the email address you provided
				in your profile settings.
			</p>
		</CardDescription>

		<form @submit.prevent="submit">
			<div class="mt-4 flex items-center justify-between">
				<Button :disabled="form.processing">Resend Verification Email</Button>

				<div>
					<Button variant="link" as-child>
						<Link :href="route('profile.show')"> Edit Profile</Link>
					</Button>

					<Button variant="link" as-child>
						<Link :href="route('logout')" method="post"> Log Out </Link>
					</Button>
				</div>
			</div>
		</form>
	</AuthenticationLayout>
</template>
