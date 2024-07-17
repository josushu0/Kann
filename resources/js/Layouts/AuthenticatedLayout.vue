<script setup lang="ts">
import { ref } from 'vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import { Link, router } from '@inertiajs/vue3'
import { MenuMethods } from 'primevue/menu'
import { MenuItem } from 'primevue/menuitem'

defineProps<{
	title: string
	dashboard?: boolean
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

const currentRoute = ref(route().current())
const routes = ref([
	{ label: 'Dashboard', value: 'dashboard' },
	{ label: 'Users', value: 'users.index' },
	{ label: 'Roles', value: 'roles.index' },
])
</script>

<template>
	<div class="flex h-screen flex-col bg-surface-100 dark:bg-surface-950">
		<nav
			class="flex items-center justify-between border-b bg-inherit px-4 border-surface"
			:class="{ 'py-1': !dashboard, 'py-1 md:py-0': dashboard }">
			<div class="flex items-center gap-2">
				<Link
					:href="route('dashboard')"
					class="rounded outline-1 focus:outline focus:outline-primary">
					<ApplicationLogo class="size-10 fill-none stroke-primary" />
				</Link>
				<div v-if="dashboard && currentRoute">
					<div class="block md:hidden">
						<Drawer v-model:visible="navDrawer">
							<div class="flex flex-col">
								<Link
									:href="route('dashboard')"
									class="py-2"
									:class="{ 'text-primary': $page.component === 'Dashboard' }">
									Dashboard
								</Link>
								<Link
									:href="route('users.index')"
									class="py-2"
									:class="{ 'text-primary': $page.component === 'Users/List' }">
									Users
								</Link>
								<Link
									:href="route('roles.index')"
									class="py-2"
									:class="{ 'text-primary': $page.component === 'Roles/List' }">
									Roles
								</Link>
							</div>
						</Drawer>
						<Button
							icon="pi pi-bars"
							text
							severity="secondary"
							@click="navDrawer = true" />
					</div>
					<div class="hidden md:block">
						<Tabs :value="currentRoute">
							<TabList
								pt:tabs:class="!bg-surface-100 dark:!bg-surface-950 !border-0">
								<Link
									:href="route(tab.value)"
									v-for="tab in routes"
									:key="tab.value">
									<Tab :value="tab.value" pt:root:class="!py-3">
										{{ tab.label }}
									</Tab>
								</Link>
							</TabList>
						</Tabs>
					</div>
				</div>
				<span v-else class="font-bold">{{ title }}</span>
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
