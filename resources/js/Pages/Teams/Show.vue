<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import DeleteTeamForm from '@/Pages/Teams/Partials/DeleteTeamForm.vue'
import UpdateTeamNameForm from '@/Pages/Teams/Partials/UpdateTeamNameForm.vue'
import { Separator } from '@/Components/shadcn/ui/separator/index.js'
import AddTeamMember from '@/Pages/Teams/Partials/AddTeamMember.vue'
import TeamInvitations from '@/Pages/Teams/Partials/TeamInvitations.vue'
import ManageTeamMembers from '@/Pages/Teams/Partials/ManageTeamMembers.vue'

defineProps({
	team: Object,
	availableRoles: Array,
	permissions: Object,
})
</script>

<template>
	<AppLayout title="Team Settings">
		<div class="container flex flex-col gap-6">
			<UpdateTeamNameForm :team="team" :permissions="permissions" />

			<template v-if="permissions.canAddTeamMembers">
				<Separator />
				<AddTeamMember
					:team="team"
					:available-roles="availableRoles"
					:user-permissions="permissions" />
			</template>

			<template
				v-if="
					team.team_invitations.length > 0 && permissions.canAddTeamMembers
				">
				<Separator />
				<TeamInvitations :team="team" :user-permissions="permissions" />
			</template>

			<template v-if="team.users.length > 0">
				<Separator />
				<ManageTeamMembers
					:team="team"
					:user-permissions="permissions"
					:availableRoles="availableRoles" />
			</template>

			<template v-if="permissions.canDeleteTeam && !team.personal_team">
				<Separator />
				<DeleteTeamForm :team="team" />
			</template>
		</div>
	</AppLayout>
</template>
