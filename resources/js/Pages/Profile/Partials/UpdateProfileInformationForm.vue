<script setup>
import { useForm } from '@inertiajs/vue3'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import { Input } from '@/Components/shadcn/ui/input/index.js'
import { Card, CardContent } from '@/Components/shadcn/ui/card/index.js'
import InputError from '@/Components/InputError.vue'
import { Button } from '@/Components/shadcn/ui/button/index.js'
import { Avatar, AvatarImage } from '@/Components/shadcn/ui/avatar/index.js'
import { Icon } from '@iconify/vue'

const props = defineProps({
	user: Object,
})

const form = useForm({
	_method: 'PUT',
	name: props.user.name,
	email: props.user.email,
	department: props.user.department,
	phone: props.user.phone,
	location: props.user.location,
})

const updateProfileInformation = () => {
	form.post(route('user-profile-information.update'), {
		errorBag: 'updateProfileInformation',
		preserveScroll: true,
		onSuccess: () => clearPhotoFileInput(),
	})
}
</script>

<template>
	<form
		@submit.prevent="updateProfileInformation"
		class="grid gap-4 md:grid-cols-3">
		<div>
			<h2 class="font-bold">Profile information</h2>
			<p class="text-sm">
				Update your account's profile information and email address.
			</p>
		</div>

		<Card class="col-span-2">
			<CardContent class="mt-6 space-y-4">
				<div class="flex flex-col items-center gap-6 sm:flex-row">
					<Avatar class="size-40">
						<AvatarImage :src="user.avatar" alt="Profile Image" />
					</Avatar>
					<Button class="flex items-center gap-2">
						<Icon icon="tabler:brand-gravatar" class="size-4" />
						<a href="https://gravatar.com" target="_blank">Edit Gravatar</a>
					</Button>
				</div>
				<div>
					<Label for="name">Name</Label>
					<Input type="text" id="name" name="name" v-model="form.name" />
					<InputError :message="form.errors.name" class="mt-2" />
				</div>
				<div>
					<Label for="email">Email</Label>
					<Input type="email" id="email" name="email" v-model="form.email" />
					<InputError :message="form.errors.email" class="mt-2" />
				</div>
				<div>
					<Label for="department">Department</Label>
					<Input
						type="text"
						id="department"
						name="department"
						v-model="form.department" />
					<InputError :message="form.errors.department" class="mt-2" />
				</div>
				<div>
					<Label for="phone">Phone</Label>
					<Input type="text" id="phone" name="phone" v-model="form.phone" />
					<InputError :message="form.errors.phone" class="mt-2" />
				</div>
				<div>
					<Label for="location">Location</Label>
					<Input
						type="text"
						id="location"
						name="location"
						v-model="form.location" />
					<InputError :message="form.errors.location" class="mt-2" />
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
