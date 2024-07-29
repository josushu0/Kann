<script setup>
import {
	DropdownMenu,
	DropdownMenuContent,
	DropdownMenuItem,
	DropdownMenuLabel,
	DropdownMenuSeparator,
	DropdownMenuTrigger,
} from '@/Components/shadcn/ui/dropdown-menu/index.js'
import { Icon } from '@iconify/vue'
import { Link, router } from '@inertiajs/vue3'
import { Button } from '@/Components/shadcn/ui/button/index.js'

const switchToTeam = (team) => {
	router.put(
		route('current-team.update'),
		{
			team_id: team.id,
		},
		{
			preserveState: false,
		}
	)
}
</script>

<template>
	<DropdownMenu v-if="$page.props.jetstream.hasTeamFeatures">
		<DropdownMenuTrigger as-child>
			<Button variant="ghost" class="flex items-center gap-2">
				{{ $page.props.auth.user.current_team.name }}
				<Icon icon="lucide:chevrons-up-down" />
			</Button>
		</DropdownMenuTrigger>
		<DropdownMenuContent class="w-48">
			<DropdownMenuLabel>Manage Team</DropdownMenuLabel>
			<DropdownMenuItem as-child v-if="$page.props.jetstream.canCreateTeams">
				<Link :href="route('teams.create')"> Create New Team</Link>
			</DropdownMenuItem>
			<DropdownMenuSeparator
				v-if="$page.props.auth.user.all_teams.lenght > 1" />

			<template v-if="$page.props.auth.user.all_teams.length > 1">
				<DropdownMenuLabel>Switch Teams</DropdownMenuLabel>
				<template
					v-for="team in $page.props.auth.user.all_teams"
					:key="team.id">
					<form @submit.prevent="switchToTeam(team)">
						<DropdownMenuItem as="button" type="submit" class="w-full">
							{{ team.name }}
						</DropdownMenuItem>
					</form>
				</template>
			</template>
		</DropdownMenuContent>
	</DropdownMenu>
</template>
