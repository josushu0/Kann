<script setup lang="ts">
import { ref } from 'vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import { MenuMethods } from 'primevue/menu'
import { MenuItem } from 'primevue/menuitem'

const props = defineProps<{
	title?: string
	projectId?: number
}>()

const navDrawer = ref(false)
const userMenu = ref<MenuMethods | null>(null)
const userMenuItems = ref<MenuItem[]>([
	{
		label: 'Profile',
		icon: 'pi pi-user',
		command: () => {
			router.get(route('profile.edit'))
		},
	},
	{
		label: 'Log out',
		icon: 'pi pi-sign-out',
		command: () => {
			router.post(route('logout'))
		},
	},
])
const toggleUserMenu = (event: MouseEvent) => {
	userMenu.value?.toggle(event)
}

const page = usePage()

const dashboard =
	page.component.startsWith('Users') ||
	page.component.startsWith('Roles') ||
	page.component === 'Projects/List'
const dashboardRoutes = ref([
	{ label: 'Projects', route: route('projects.index') },
	{ label: 'Users', route: route('users.index') },
	{ label: 'Roles', route: route('roles.index') },
])

const project =
	page.component === 'Projects/Show' || page.component === 'Projects/Edit'
const projectRoutes = ref([
	{
		label: 'Tasks',
		route: route('projects.show', project ? props.projectId : ''),
		value: 'Show',
	},
	{
		label: 'Settings',
		route: route('projects.edit', project ? props.projectId : ''),
		value: 'Edit',
	},
])
</script>

<template>
	<div class="flex h-screen flex-col bg-surface-100 dark:bg-surface-950">
		<nav
			class="flex items-center justify-between border-b bg-inherit px-4 border-surface"
			:class="{
				'py-1': !dashboard && !project,
				'py-1 md:py-0': dashboard || project,
			}">
			<div class="flex items-center gap-2">
				<Link
					:href="route('projects.index')"
					class="rounded outline-1 focus:outline focus:outline-primary">
					<ApplicationLogo class="size-10 fill-none stroke-primary" />
				</Link>
				<div class="block md:hidden">
					<Drawer v-model:visible="navDrawer">
						<div
							v-if="dashboard"
							v-for="link in dashboardRoutes"
							:key="link.route"
							class="flex flex-col">
							<Link :href="link.route" class="py-2">
								{{ link.label }}
							</Link>
						</div>
						<div
							v-if="project"
							v-for="link in projectRoutes"
							:key="link.value"
							class="flex flex-col">
							<Link :href="link.route" class="py-2">
								{{ link.label }}
							</Link>
						</div>
					</Drawer>
					<Button
						icon="pi pi-bars"
						text
						severity="secondary"
						@click="navDrawer = true" />
				</div>
				<div v-if="dashboard" class="hidden md:block">
					<Tabs :value="$page.component.split('/')[0]">
						<TabList
							pt:tabs:class="!bg-surface-100 dark:!bg-surface-950 !border-0">
							<Link
								:href="tab.route"
								v-for="tab in dashboardRoutes"
								:key="tab.route">
								<Tab :value="tab.label" pt:root:class="!py-3">
									{{ tab.label }}
								</Tab>
							</Link>
						</TabList>
					</Tabs>
				</div>
				<div v-if="project" class="hidden md:block">
					<Tabs :value="$page.component.split('/')[1]">
						<TabList
							pt:tabs:class="!bg-surface-100 dark:!bg-surface-950 !border-0">
							<Link
								:href="tab.route"
								v-for="tab in projectRoutes"
								:key="tab.route">
								<Tab :value="tab.value" pt:root:class="!py-3">
									{{ tab.label }}
								</Tab>
							</Link>
						</TabList>
					</Tabs>
				</div>
				<span v-if="title" class="font-bold">{{ title }}</span>
			</div>
			<Button
				icon="pi"
				rounded
				text
				aria-haspopup="true"
				aria-controls="user_menu"
				@click="toggleUserMenu">
				<Avatar :image="$page.props.auth.user.avatar" shape="circle"></Avatar>
			</Button>
			<Menu
				ref="userMenu"
				id="user_menu"
				:popup="true"
				:model="userMenuItems" />
		</nav>

		<!-- Page Content -->
		<main class="h-full overflow-auto">
			<slot />
		</main>
	</div>
</template>
