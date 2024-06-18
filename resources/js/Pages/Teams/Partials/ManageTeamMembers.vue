<script setup>
import { Card, CardContent } from '@/Components/shadcn/ui/card/index.js'
import { Avatar, AvatarImage } from '@/Components/shadcn/ui/avatar/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'
import {
	Dialog,
	DialogClose,
	DialogContent,
	DialogDescription,
	DialogHeader,
	DialogTitle,
	DialogTrigger,
} from '@/Components/shadcn/ui/dialog/index.js'
import { useForm, usePage } from '@inertiajs/vue3'
import {
	ToggleGroup,
	ToggleGroupItem,
} from '@/Components/shadcn/ui/toggle-group/index.js'
import { Label } from '@/Components/shadcn/ui/label/index.js'
import InputError from '@/Components/InputError.vue'
import { ref } from 'vue'

const props = defineProps({
	team: Object,
	availableRoles: Array,
	userPermissions: Object,
})

const openRole = ref(false)
const updateRoleForm = useForm({
	role: null,
})
const updateRole = (member) => {
	updateRoleForm.put(route('team-members.update', [props.team, member]), {
		preserveScroll: true,
		onFinish: () => (openRole.value = false),
	})
}

const openLeave = ref(false)
const leaveTeamForm = useForm({})
const leaveTeam = () => {
	leaveTeamForm.delete(
		route('team-members.destroy', [props.team, page.props.auth.user]),
		{
			preserveScroll: true,
			onfinish: () => (openLeave.value = false),
		}
	)
}

const page = usePage()
const openRemove = ref(false)
const removeTeamMemberForm = useForm({})
const removeTeamMember = (member) => {
	removeTeamMemberForm.delete(
		route('team-members.destroy', [props.team, member]),
		{
			errorBag: 'removeTeamMember',
			preserveScroll: true,
			preserveState: true,
			onSuccess: () => (openRemove.value = false),
		}
	)
}

const displayableRole = (role) => {
	return props.availableRoles.find((r) => r.key === role).name
}
</script>

<template>
	<div>
		<div class="grid gap-4 md:grid-cols-3">
			<div>
				<h2 class="font-bold">Team Members</h2>
				<p class="text-sm">All of the people that are part of this team.</p>
			</div>

			<Card class="col-span-2">
				<CardContent class="mt-6 space-y-4">
					<div
						v-for="user in team.users"
						:key="user.id"
						class="flex items-center justify-between">
						<!-- User -->
						<div class="flex items-center gap-2">
							<Avatar>
								<AvatarImage :src="user.profile_photo_path" />
							</Avatar>
							{{ user.name }}
						</div>

						<!-- Actions -->
						<div class="flex items-center gap-2">
							<!-- Manage role -->
							<Dialog v-model:open="openRole">
								<DialogTrigger as-child>
									<Button
										v-if="availableRoles.length"
										variant="link"
										:disabled="!userPermissions.canUpdateTeamMembers"
										@click="() => (updateRoleForm.role = user.membership.role)">
										{{ displayableRole(user.membership.role) }}
									</Button>
								</DialogTrigger>
								<DialogContent>
									<DialogHeader>
										<DialogTitle>Manage Role</DialogTitle>
										<DialogDescription class="sr-only"
											>Change role of team member
										</DialogDescription>
									</DialogHeader>
									<Label for="role">Role</Label>
									<InputError
										:message="updateRoleForm.errors.role"
										class="mt-2" />
									<ToggleGroup
										type="single"
										:model-value="updateRoleForm.role"
										@update:model-value="
											(val) => {
												if (val) updateRoleForm.role = val
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

									<div class="flex justify-end gap-2">
										<DialogClose as-child>
											<Button variant="outline">Cancel</Button>
										</DialogClose>
										<Button
											:disabled="updateRoleForm.processing"
											@click="updateRole(user)">
											Save
										</Button>
									</div>
								</DialogContent>
							</Dialog>

							<!-- Leave Team -->
							<Dialog
								v-if="$page.props.auth.user.id === user.id"
								v-model:open="openLeave">
								<DialogTrigger as-child>
									<Button variant="destructive"> Leave</Button>
								</DialogTrigger>
								<DialogContent>
									<DialogHeader>
										<DialogTitle>Leave Team</DialogTitle>
										<DialogDescription>
											Are you sure you want to leave this team?
										</DialogDescription>
									</DialogHeader>
									<div class="flex justify-end gap-2">
										<DialogClose as-child>
											<Button variant="outline">Cancel</Button>
										</DialogClose>
										<Button
											variant="destructive"
											:disabled="leaveTeamForm.processing"
											@click="leaveTeam">
											Leave
										</Button>
									</div>
								</DialogContent>
							</Dialog>

							<!-- Remove Team Member -->
							<Dialog
								v-else-if="userPermissions.canRemoveTeamMembers"
								v-model:open="openRemove">
								<DialogTrigger as-child>
									<Button variant="destructive">Remove</Button>
								</DialogTrigger>
								<DialogContent>
									<DialogHeader>
										<DialogTitle>Remove Team Member</DialogTitle>
										<DialogDescription>
											Are you sure you would like to remove this person from the
											team?
										</DialogDescription>
									</DialogHeader>
									<div class="flex justify-end gap-2">
										<DialogClose as-child>
											<Button variant="outline">Cancel</Button>
										</DialogClose>
										<Button
											variant="destructive"
											:disabled="removeTeamMemberForm.processing"
											@click="removeTeamMember(user)">
											Remove
										</Button>
									</div>
								</DialogContent>
							</Dialog>
						</div>
					</div>
				</CardContent>
			</Card>
		</div>
	</div>
</template>
