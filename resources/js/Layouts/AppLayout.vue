<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3'
import Banner from '@/Components/Banner.vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import TeamSelector from '@/Components/TeamSelector.vue'
import ThemeSelector from '@/Components/ThemeSelector.vue'
import UserMenu from '@/Components/UserMenu.vue'

const props = defineProps({
	title: {
		type: String,
		required: false,
	},
	project: {
		type: String,
		default: '',
	},
})

const page = usePage()
const dashboard =
	page.component.startsWith('Users') ||
	page.component === 'Projects/List' ||
	page.component === 'Teams/Show'
const dashboardLinks = [
	{
		label: 'Projects',
		route: route('projects.index'),
		component: 'Projects/List',
	},
	{
		label: 'Settings',
		route: route('teams.show', page.props.auth.user.current_team),
		component: 'Teams/Show',
	},
]

const projectLinks = [
	{
		label: 'Tasks',
		route: route('projects.show', props.project),
		component: 'Projects/Show'
	},
	{
		label: 'Settings',
		route: route('projects.edit', props.project),
		component: 'Projects/Edit'
	}
]
</script>

<template>
	<div>

		<Head :title="title" />

		<Banner />

		<div class="flex h-dvh flex-col bg-background">
			<!-- Page navbar -->
			<header>
				<nav class="flex items-center justify-between bg-background px-6 py-3"
					:class="{ 'border-b border-border': !project && !dashboard }">
					<div class="flex items-center justify-between gap-2">
						<Link :href="route('projects.index')"
							class="rounded outline-none focus-visible:ring-2 focus-visible:ring-primary">
						<span class="sr-only">Home</span>
						<ApplicationLogo class="size-9 fill-background stroke-primary" />
						</Link>
						<h1 v-if="title" class="font-bold">{{ title }}</h1>
					</div>
					<div class="flex items-center justify-between gap-2">
						<TeamSelector />
						<ThemeSelector />
						<UserMenu :src="$page.props.auth.user.avatar" />
					</div>
				</nav>

				<!-- Project Links -->
				<div v-if="project" class="flex border-b border-border bg-background px-6">
					<Link v-for="link in projectLinks" :key="link.route" :href="link.route" class="px-3 pb-2" :class="{
						'border-b border-primary': $page.component === link.component,
					}">
					{{ link.label }}
					</Link>
				</div>

				<!-- Dashboard Links -->
				<div v-if="dashboard" class="flex border-b border-border bg-background px-6">
					<Link v-for="link in dashboardLinks" :key="link.route" :href="link.route" class="px-3 pb-2" :class="{
						'border-b border-primary': $page.component === link.component,
					}">
					{{ link.label }}
					</Link>
					<Link v-if="$page.props.auth.user.is_admin" :href="route('users.index')" class="px-3 pb-2" :class="{
						'border-b border-primary': $page.component.startsWith('Users'),
					}">
					Users
					</Link>
				</div>
			</header>

			<!-- Page Content -->
			<main class="h-full overflow-auto py-6">
				<slot />
			</main>
		</div>
	</div>
</template>
