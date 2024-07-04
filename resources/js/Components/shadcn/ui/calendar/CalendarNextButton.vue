<script setup>
import { computed } from 'vue'
import { CalendarNext, useForwardProps } from 'radix-vue'
import { cn } from '@/lib/utils'
import { buttonVariants } from '@/Components/shadcn/ui/button'
import { Icon } from '@iconify/vue'

const props = defineProps({
	step: { type: String, required: false },
	asChild: { type: Boolean, required: false },
	as: { type: null, required: false },
	class: { type: null, required: false },
})

const delegatedProps = computed(() => {
	const { class: _, ...delegated } = props

	return delegated
})

const forwardedProps = useForwardProps(delegatedProps)
</script>

<template>
	<CalendarNext
		:class="
			cn(
				buttonVariants({ variant: 'outline' }),
				'h-7 w-7 bg-transparent p-0 opacity-50 hover:opacity-100',
				props.class
			)
		"
		v-bind="forwardedProps">
		<slot>
			<Icon icon="lucide:chevron-right" class="size-4" />
		</slot>
	</CalendarNext>
</template>
