<script setup>
import { useForm } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import { Card, CardContent } from '@/Components/shadcn/ui/card/index.js'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import { Avatar, AvatarImage } from '@/Components/shadcn/ui/avatar/index.js'
import { Input } from '@/Components/shadcn/ui/input/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'

const props = defineProps({
	team: Object,
	permissions: Object,
})

const form = useForm({
	name: props.team.name,
})

const updateTeamName = () => {
	form.put(route('teams.update', props.team), {
		errorBag: 'updateTeamName',
		preserveScroll: true,
	})
}
</script>

<template>
	<form @submit.prevent="updateTeamName" class="grid gap-4 md:grid-cols-3">
		<div>
			<h2 class="font-bold">Team Name</h2>
			<p class="text-sm">The team's name and owner information.</p>
		</div>

		<Card class="col-span-2">
			<CardContent class="mt-6 space-y-4">
				<!-- Team Owner Information -->
				<div class="space-y-2">
					<Label>Team Owner</Label>
					<div class="flex items-center gap-2">
						<Avatar>
							<AvatarImage :src="team.owner.profile_photo_path" alt="" />
						</Avatar>
						<div>
							<p>{{ team.owner.name }}</p>
							<p class="text-sm">{{ team.owner.email }}</p>
						</div>
					</div>
				</div>

				<!-- Team Name -->
				<div>
					<Label for="name">Team Name</Label>
					<Input
						type="text"
						id="name"
						name="name"
						v-model="form.name"
						:disabled="!permissions.canUpdateTeam" />
					<InputError :message="form.errors.name" class="mt-2" />
				</div>

				<!-- Actions -->
				<div
					v-if="permissions.canUpdateTeam"
					class="flex items-center justify-end gap-2">
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
