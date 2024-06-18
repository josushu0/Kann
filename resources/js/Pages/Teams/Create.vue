<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Card, CardContent } from '@/Components/shadcn/ui/card/index.js'
import { Avatar, AvatarImage } from '@/Components/shadcn/ui/avatar/index.js'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import InputError from '@/Components/InputError.vue'
import { useForm } from '@inertiajs/vue3'
import { Input } from '@/Components/shadcn/ui/input/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'

const form = useForm({
	name: '',
})

const createTeam = () => {
	form.post(route('teams.store'), {
		errorBag: 'createTeam',
		preserveScroll: true,
	})
}
</script>

<template>
	<AppLayout title="Create Team">
		<div class="container flex flex-col gap-6">
			<form @submit.prevent="createTeam" class="grid gap-4 md:grid-cols-3">
				<div>
					<h2 class="font-bold">Team Details</h2>
					<p class="text-sm">
						Create a new team to collaborate with others in projects.
					</p>
				</div>

				<Card class="col-span-2">
					<CardContent class="mt-6 space-y-4">
						<!-- Team Owner Information -->
						<div class="space-y-2">
							<Label>Team Owner</Label>
							<div class="flex items-center gap-2">
								<Avatar>
									<AvatarImage
										:src="$page.props.auth.user.profile_photo_path"
										alt="" />
								</Avatar>
								<div>
									<p>{{ $page.props.auth.user.name }}</p>
									<p class="text-sm">{{ $page.props.auth.user.email }}</p>
								</div>
							</div>
						</div>

						<!-- Team Name -->
						<div>
							<Label for="name">Team Name</Label>
							<Input type="text" id="name" name="name" v-model="form.name" />
							<InputError :message="form.errors.name" class="mt-2" />
						</div>

						<!-- Actions -->
						<div class="flex items-center justify-end gap-2">
							<Button type="submit" :disabled="form.processing">Create</Button>
						</div>
					</CardContent>
				</Card>
			</form>
		</div>
	</AppLayout>
</template>
