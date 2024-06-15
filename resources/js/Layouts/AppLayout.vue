<script setup>
import { Head, Link } from '@inertiajs/vue3'
import Banner from '@/Components/Banner.vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import TeamSelector from '@/Components/TeamSelector.vue'
import ThemeSelector from '@/Components/ThemeSelector.vue'
import UserMenu from '@/Components/UserMenu.vue'

defineProps({
	title: String,
})
</script>

<template>
	<div>
		<Head :title="title" />

		<Banner />

		<div class="h-dvh bg-background">
			<!-- Page navbar -->
			<header class="sticky top-0 z-50">
				<nav
					class="flex items-center justify-between border-b border-border bg-background px-6 py-3">
					<div class="flex items-center justify-between gap-2">
						<Link
							:href="route('projects.show')"
							class="rounded outline-none focus-visible:ring-2 focus-visible:ring-primary">
							<span class="sr-only">Home</span>
							<ApplicationLogo class="size-9 fill-background stroke-primary" />
						</Link>
						<h1 class="font-bold">{{ title }}</h1>
					</div>
					<div class="flex items-center justify-between gap-2">
						<TeamSelector />
						<ThemeSelector />
						<UserMenu :src="$page.props.auth.user.profile_photo_path" />
					</div>
				</nav>
			</header>

			<!-- Page Content -->
			<main class="py-10">
				<slot />
			</main>
		</div>
	</div>
</template>
