<script setup>
import { Card } from '@/Components/shadcn/ui/card'
import { CardContent } from '@/Components/shadcn/ui/card/index.js'
</script>

<template>
	<div
		class="flex h-dvh flex-col items-center bg-background pt-6 sm:justify-center sm:pt-0">
		<slot name="logo" />
		<Card class="w-full sm:max-w-md">
			<CardContent class="mt-6">
				<slot />
			</CardContent>
		</Card>
	</div>
</template>
