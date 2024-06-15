<script setup>
import { Link } from '@inertiajs/vue3'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import { Button } from '@/Components/shadcn/ui/button/index.js'
import {
	Sheet,
	SheetContent,
	SheetTrigger,
} from '@/Components/shadcn/ui/sheet/index.js'
import { Icon } from '@iconify/vue'
import ThemeSelector from '@/Components/ThemeSelector.vue'

defineProps({
	canLogin: Boolean,
	canRegister: Boolean,
})
</script>

<template>
	<header class="w-full">
		<nav class="flex items-center justify-between p-6">
			<Link
				href="#"
				class="rounded outline-none focus-visible:ring-2 focus-visible:ring-primary">
				<span class="sr-only">Home</span>
				<ApplicationLogo class="size-9 fill-background stroke-primary" />
			</Link>
			<div class="flex items-center gap-2">
				<div class="hidden items-center gap-2 md:flex" v-if="canLogin">
					<Button as-child v-if="$page.props.auth.user">
						<Link :href="route('projects.show')">Dashboard</Link>
					</Button>
					<template v-else>
						<Button as-child>
							<Link :href="route('login')">Login</Link>
						</Button>
						<Button as-child variant="outline" v-if="canRegister">
							<Link :href="route('register')">Register</Link>
						</Button>
					</template>
				</div>
				<ThemeSelector />
				<Sheet>
					<SheetTrigger as-child class="md:hidden">
						<Button variant="outline" size="icon">
							<Icon icon="lucide:menu" class="size-4" />
						</Button>
					</SheetTrigger>
					<SheetContent side="right">
						<div class="mt-10 space-y-2" v-if="canLogin">
							<Button
								v-if="$page.props.auth.user"
								as-child
								variant="ghost"
								size="lg"
								class="w-full justify-start text-lg font-bold">
								<Link :href="route('projects.show')">Dashboard</Link>
							</Button>
							<template v-else>
								<Button
									as-child
									variant="ghost"
									size="lg"
									class="w-full justify-start text-lg font-bold">
									<Link :href="route('login')">Login</Link>
								</Button>
								<Button
									as-child
									variant="ghost"
									size="lg"
									class="w-full justify-start text-lg font-bold">
									<Link :href="route('register')">Register</Link>
								</Button>
							</template>
						</div>
					</SheetContent>
				</Sheet>
			</div>
		</nav>
	</header>
</template>
