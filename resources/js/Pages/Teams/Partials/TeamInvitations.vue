<script setup>
import { Button } from '@/Components/shadcn/ui/button/index.js'
import { router } from '@inertiajs/vue3'
import { Card, CardContent } from '@/Components/shadcn/ui/card/index.js'

const props = defineProps({
	team: Object,
	userPermissions: Object,
})

const cancelTeamInvitation = (invitation) => {
	router.delete(route('team-invitations.destroy', invitation), {
		preserveScroll: true,
	})
}
</script>

<template>
	<div>
		<div class="grid gap-4 md:grid-cols-3">
			<div>
				<h2 class="font-bold">Pending Team Invitations</h2>
				<p class="text-sm">
					These people have been invited to your team and have been sent an
					invitation email. They may join the team by accepting the email
					invitation.
				</p>
			</div>

			<Card class="col-span-2">
				<CardContent class="mt-6 space-y-4">
					<div
						v-for="invitation in team.team_invitations"
						:key="invitation.id"
						class="flex items-center justify-between">
						<p>{{ invitation.email }}</p>
						<Button
							v-if="userPermissions.canRemoveTeamMembers"
							variant="destructive"
							@click="cancelTeamInvitation(invitation)">
							Cancel
						</Button>
					</div>
				</CardContent>
			</Card>
		</div>
	</div>
</template>
