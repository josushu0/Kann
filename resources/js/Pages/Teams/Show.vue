<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import DeleteTeamForm from '@/Pages/Teams/Partials/DeleteTeamForm.vue'
import UpdateTeamNameForm from '@/Pages/Teams/Partials/UpdateTeamNameForm.vue'
import { Separator } from '@/Components/shadcn/ui/separator/index.js'
import AddTeamMember from '@/Pages/Teams/Partials/AddTeamMember.vue'

defineProps({
	team: Object,
	availableRoles: Array,
	permissions: Object,
})
</script>

<template>
	<AppLayout title="Team Settings">
		<div>
			<div class="container flex flex-col gap-6">
				<UpdateTeamNameForm :team="team" :permissions="permissions" />

				<template v-if="permissions.canAddTeamMembers">
					<Separator />
					<AddTeamMember
						:team="team"
						:available-roles="availableRoles"
						:user-permissions="permissions" />
				</template>

				<template v-if="permissions.canDeleteTeam && !team.personal_team">
					<SectionBorder />

					<DeleteTeamForm class="mt-10 sm:mt-0" :team="team" />
				</template>
			</div>
		</div>
	</AppLayout>
</template>
