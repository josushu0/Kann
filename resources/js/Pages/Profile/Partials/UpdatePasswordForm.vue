<script setup>
import { useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import { Card, CardContent } from '@/Components/shadcn/ui/card/index.js'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import { Input } from '@/Components/shadcn/ui/input/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'

const form = useForm({
	current_password: '',
	password: '',
	password_confirmation: '',
})

const updatePassword = () => {
	form.put(route('user-password.update'), {
		errorBag: 'updatePassword',
		preserveScroll: true,
		onSuccess: () => form.reset(),
		onError: () => {
			if (form.errors.password) {
				form.reset('password', 'password_confirmation')
			}

			if (form.errors.current_password) {
				form.reset('current_password')
			}
		},
	})
}
</script>

<template>
	<form @submit.prevent="updatePassword" class="grid gap-4 md:grid-cols-3">
		<div>
			<h2 class="font-bold">Update Password</h2>
			<p class="text-sm">
				Ensure your account is using a long, random password to stay secure.
			</p>
		</div>

		<Card class="col-span-2">
			<CardContent class="mt-6 space-y-4">
				<div>
					<Label for="current_password">Current Password</Label>
					<Input
						type="password"
						id="current_password"
						name="current_password"
						v-model="form.current_password" />
					<InputError :message="form.errors.current_password" class="mt-2" />
				</div>
				<div>
					<Label for="password">New Password</Label>
					<Input
						type="password"
						id="password"
						name="password"
						v-model="form.password" />
					<InputError :message="form.errors.password" class="mt-2" />
				</div>
				<div>
					<Label for="password_confirmation">Confirm Password</Label>
					<Input
						type="password"
						id="password_confirmation"
						name="password_confirmation"
						v-model="form.password_confirmation" />
					<InputError
						:message="form.errors.password_confirmation"
						class="mt-2" />
				</div>

				<div class="flex items-center justify-end gap-2">
					<transition
						leave-active-class="transition ease-in duration-1000"
						leave-from-class="opacity-100"
						leave-to-class="opacity-0">
						<span
							v-show="form.recentlySuccessful"
							class="text-sm text-gray-600">
							Saved.
						</span>
					</transition>
					<Button type="submit" :disabled="form.processing">Save</Button>
				</div>
			</CardContent>
		</Card>
	</form>
</template>
