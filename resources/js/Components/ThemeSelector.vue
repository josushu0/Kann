<script setup>
import {
	DropdownMenu,
	DropdownMenuContent,
	DropdownMenuLabel,
	DropdownMenuRadioGroup,
	DropdownMenuRadioItem,
	DropdownMenuTrigger,
} from '@/Components/shadcn/ui/dropdown-menu/index.js'
import { Icon } from '@iconify/vue'
import { useColorMode } from '@vueuse/core'
import { Button } from '@/Components/shadcn/ui/button/index.js'

const { store: colorMode } = useColorMode()

function setColorMode(mode) {
	colorMode.value = mode
}
</script>

<template>
	<DropdownMenu>
		<DropdownMenuTrigger as-child>
			<Button
				variant="ghost"
				size="icon"
				class="flex items-center justify-center">
				<Icon
					icon="lucide:sun"
					class="size-5 rotate-0 scale-100 transition-all dark:-rotate-90 dark:scale-0" />
				<Icon
					icon="lucide:moon"
					class="absolute size-5 rotate-90 scale-0 transition-all dark:rotate-0 dark:scale-100" />
			</Button>
		</DropdownMenuTrigger>
		<DropdownMenuContent>
			<DropdownMenuLabel>Select a theme</DropdownMenuLabel>
			<DropdownMenuRadioGroup v-model="colorMode">
				<DropdownMenuRadioItem value="light" @click="setColorMode('light')">
					Light
				</DropdownMenuRadioItem>
				<DropdownMenuRadioItem value="dark" @click="setColorMode('dark')">
					Dark
				</DropdownMenuRadioItem>
				<DropdownMenuRadioItem value="auto" @click="setColorMode('auto')">
					System
				</DropdownMenuRadioItem>
			</DropdownMenuRadioGroup>
		</DropdownMenuContent>
	</DropdownMenu>
</template>
