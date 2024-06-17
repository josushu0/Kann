<script setup>
import { useForm } from '@inertiajs/vue3'
import {
	Card,
	CardContent,
	CardDescription,
} from '@/Components/shadcn/ui/card/index.js'
import ConfirmsPassword from '@/Components/ConfirmsPassword.vue'
import { Button } from '@/Components/shadcn/ui/button/index.js'

const form = useForm({
	password: '',
})

const deleteUser = (password) => {
	form.password = password
	form.delete(route('current-user.destroy'), {
		preserveScroll: true,
		onFinish: () => form.reset(),
	})
}
</script>

<template>
	<div class="grid gap-4 md:grid-cols-3">
		<div>
			<h2 class="font-bold">Delete Account</h2>
			<p class="text-sm">Permanently delete your account.</p>
		</div>

		<Card class="col-span-2">
			<CardContent class="mt-6 space-y-4">
				<CardDescription>
					Once your account is deleted, all of its resources and data will be
					permanently deleted. Before deleting your account, please download any
					data or information that you wish to retain.
				</CardDescription>
				<div class="flex justify-end gap-2">
					<ConfirmsPassword
						title="Delete Account"
						content="Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account."
						button="Delete Account"
						@confirmed="(password) => deleteUser(password)">
						<Button variant="destructive">Delete Account</Button>
					</ConfirmsPassword>
				</div>
			</CardContent>
		</Card>
	</div>
</template>
