<script setup lang="ts">
import InputError from '@/Components/InputError.vue'
import { useForm, usePage } from '@inertiajs/vue3'

defineProps<{
	status?: String
}>()

const user = usePage().props.auth.user

const form = useForm({
	name: user.name,
	email: user.email,
})
</script>

<template>
	<Card>
		<template #title>
			<h2>Profile information</h2>
		</template>

		<template #subtitle>
			<p>Update your account's profile information and email address.</p>
		</template>

		<template #content>
			<form
				@submit.prevent="form.patch(route('profile.update'))"
				class="space-y-4">
				<div class="flex flex-col">
					<label for="name" class="text-sm">Name</label>

					<InputText
						id="name"
						type="text"
						v-model="form.name"
						required
						:invalid="form.errors.name ? true : false" />

					<InputError :message="form.errors.name" />
				</div>

				<div class="flex flex-col">
					<label for="email">Email</label>

					<InputText
						id="email"
						type="email"
						v-model="form.email"
						required
						:invalid="form.errors.email ? true : false" />

					<InputError :message="form.errors.email" />
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
