<script setup>
import { computed } from 'vue'
import { ComboboxInput, useForwardProps } from 'radix-vue'
import { cn } from '@/lib/utils'
import { Icon } from '@iconify/vue'

defineOptions({
	inheritAttrs: false,
})

const props = defineProps({
	type: { type: String, required: false },
	disabled: { type: Boolean, required: false },
	autoFocus: { type: Boolean, required: false },
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
	<div class="flex items-center border-b px-3" cmdk-input-wrapper>
		<Icon icon="lucide:search" class="mr-2 size-4 shrink-0 opacity-50" />
		<ComboboxInput
			v-bind="{ ...forwardedProps, ...$attrs }"
			auto-focus
			:class="
				cn(
					'flex h-11 w-full rounded-md bg-transparent py-3 text-sm outline-none placeholder:text-muted-foreground disabled:cursor-not-allowed disabled:opacity-50',
					props.class
				)
			" />
	</div>
</template>
