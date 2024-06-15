<script setup>
import {
	DropdownMenu,
	DropdownMenuContent,
	DropdownMenuItem,
	DropdownMenuLabel,
	DropdownMenuSeparator,
	DropdownMenuTrigger,
} from '@/Components/shadcn/ui/dropdown-menu/index.js'
import { Button } from '@/Components/shadcn/ui/button/index.js'
import { Avatar, AvatarImage } from '@/Components/shadcn/ui/avatar/index.js'
import { Link, router } from '@inertiajs/vue3'

defineProps({
	src: String,
})

const logout = () => {
	router.post(route('logout'))
}
</script>

<template>
	<DropdownMenu>
		<DropdownMenuTrigger as-child>
			<Button variant="ghost" size="icon" class="rounded-full">
				<Avatar>
					<AvatarImage :src="src" alt="" />
				</Avatar>
			</Button>
		</DropdownMenuTrigger>
		<DropdownMenuContent>
			<DropdownMenuLabel>Manage Account</DropdownMenuLabel>
			<DropdownMenuItem as-child>
				<Link :href="route('profile.show')">Profile</Link>
			</DropdownMenuItem>
			<DropdownMenuSeparator />
			<form @submit.prevent="logout">
				<DropdownMenuItem as="button" type="submit" class="w-full"
					>Logout</DropdownMenuItem
				>
			</form>
		</DropdownMenuContent>
	</DropdownMenu>
</template>
