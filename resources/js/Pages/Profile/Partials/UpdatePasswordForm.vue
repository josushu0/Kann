<script setup lang="ts">
import InputError from '@/Components/InputError.vue'
import { useForm } from '@inertiajs/vue3'

const form = useForm({
	current_password: '',
	password: '',
	password_confirmation: '',
})

const updatePassword = () => {
	form.put(route('password.update'), {
		preserveScroll: true,
		onSuccess: () => {
			form.reset()
		},
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
	<Card>
		<template #title>
			<h2>Update Password</h2>
		</template>
		<template #subtitle>
			Ensure your account is using a long, random password to stay secure.
		</template>
		<template #content>
			<form @submit.prevent="updatePassword" class="space-y-4">
				<div class="flex flex-col">
					<label for="current_password">Current Password</label>

					<Password
						id="current_password"
						:pt="{ pcInput: { root: { class: 'w-full' } } }"
						:invalid="form.errors.current_password ? true : false"
						toggle-mask
						:feedback="false"
						v-model="form.current_password" />

					<InputError :message="form.errors.current_password" />
				</div>

				<div class="flex flex-col">
					<label for="password">New Password</label>

					<Password
						id="password"
						:pt="{ pcInput: { root: { class: 'w-full' } } }"
						:invalid="form.errors.password ? true : false"
						toggle-mask
						v-model="form.password" />

					<InputError :message="form.errors.password" />
				</div>

				<div class="flex flex-col">
					<label for="password_confirmation">Confirm Password</label>

					<Password
						id="password_confirmation"
						:pt="{ pcInput: { root: { class: 'w-full' } } }"
						:invalid="form.errors.password_confirmation ? true : false"
						toggle-mask
						v-model="form.password_confirmation" />

					<InputError :message="form.errors.password_confirmation" />
				</div>

				<div class="flex items-center justify-end gap-4">
					<Button type="submit" :disabled="form.processing" label="Save" />

					<Transition
						enter-active-class="transition ease-in-out"
						enter-from-class="opacity-0"
						leave-active-class="transition ease-in-out"
						leave-to-class="opacity-0">
						<p v-if="form.recentlySuccessful" class="text-sm text-muted-color">
							Saved.
						</p>
					</Transition>
				</div>
			</form>
		</template>
	</Card>
</template>
