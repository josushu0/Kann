<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import InputError from '@/Components/InputError.vue'
import {
	Card,
	CardContent,
	CardDescription,
} from '@/Components/shadcn/ui/card/index.js'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import { Input } from '@/Components/shadcn/ui/input/index.js'
import {
	ToggleGroup,
	ToggleGroupItem,
} from '@/Components/shadcn/ui/toggle-group/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'

const props = defineProps({
	team: Object,
	availableRoles: Array,
	userPermissions: Object,
})

const page = usePage()

const addTeamMemberForm = useForm({
	email: '',
	role: null,
})

const addTeamMember = () => {
	addTeamMemberForm.post(route('team-members.store', props.team), {
		errorBag: 'addTeamMember',
		preserveScroll: true,
		onSuccess: () => addTeamMemberForm.reset(),
	})
}
</script>

<template>
	<!-- Add Members Section -->
	<div>
		<form @submit.prevent="addTeamMember" class="grid gap-4 md:grid-cols-3">
			<div>
				<h2 class="font-bold">Add Team Member</h2>
				<p class="text-sm">
					Add a new team member to your team, allowing them to collaborate with
					you.
				</p>
			</div>

			<Card class="col-span-2">
				<CardContent class="mt-6 space-y-4">
					<CardDescription>
						Please provide the email address of the person you would like to add
						to this team.
					</CardDescription>

					<!-- Member Email -->
					<div>
						<Label for="email">Email</Label>
						<Input
							type="email"
							id="email"
							name="email"
							v-model="addTeamMemberForm.email" />
						<InputError
							:message="addTeamMemberForm.errors.email"
							class="mt-2" />
					</div>

					<!-- Roles -->
					<div v-if="availableRoles.length > 0">
						<Label for="role">Role</Label>
						<InputError :message="addTeamMemberForm.errors.role" class="mt-2" />
						<ToggleGroup
							type="single"
							:model-value="addTeamMemberForm.role"
							@update:model-value="
								(val) => {
									if (val) addTeamMemberForm.role = val
								}
							"
							class="flex flex-col items-start gap-0">
							<ToggleGroupItem
								v-for="(role, index) in availableRoles"
								:key="index"
								:value="role.key"
								class="flex h-fit w-full flex-col items-start gap-1 border border-border p-2"
								:class="{
									'rounded-t-none': index > 0,
									'rounded-b-none':
										index != Object.keys(availableRoles).length - 1,
								}">
								<p class="font-bold">{{ role.name }}</p>
								<p>{{ role.description }}</p>
							</ToggleGroupItem>
						</ToggleGroup>
					</div>

					<!-- Actions -->
					<div class="flex items-center justify-end gap-2">
						<transition
							leave-active-class="transition ease-in duration-1000"
							leave-from-class="opacity-100"
							leave-to-class="opacity-0">
							<span
								v-show="addTeamMemberForm.recentlySuccessful"
								class="text-sm text-gray-600">
								Added.
							</span>
						</transition>
						<Button type="submit" :disabled="addTeamMemberForm.processing"
							>Add
						</Button>
					</div>
				</CardContent>
			</Card>
		</form>
	</div>
</template>
