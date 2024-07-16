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
])
</script>

<template>
	<div class="flex h-screen flex-col bg-surface-100 dark:bg-surface-950">
		<nav
			class="flex items-center justify-between border-b bg-inherit px-4 py-2 border-surface">
			<div class="flex items-center gap-2">
				<Link
					:href="route('dashboard')"
					class="rounded outline-1 focus:outline focus:outline-primary">
					<ApplicationLogo class="size-10 fill-none stroke-primary" />
				</Link>
				<span class="font-bold">{{ title }}</span>
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
		<Tabs
			v-if="dashboard && currentRoute"
			:value="currentRoute"
			pt:root:class="border-b border-surface">
			<TabList pt:tabs:class="!bg-surface-100 dark:!bg-surface-950 !border-0">
				<Link :href="route(tab.value)" v-for="tab in routes" :key="tab.value">
					<Tab :value="tab.value" pt:root:class="!py-2">
						{{ tab.label }}
					</Tab>
				</Link>
			</TabList>
		</Tabs>

		<!-- Page Content -->
		<main class="h-full overflow-auto">
			<slot />
		</main>
	</div>
</template>
