<script setup>
import { computed } from 'vue'
import { TagsInputItemDelete, useForwardProps } from 'radix-vue'
import { cn } from '@/lib/utils'
import { Icon } from '@iconify/vue'

const props = defineProps({
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
	<TagsInputItemDelete
		v-bind="forwardedProps"
		:class="cn('mr-1 flex rounded bg-transparent', props.class)">
		<slot>
			<Icon icon="lucide:x" class="size-4" />
		</slot>
	</TagsInputItemDelete>
</template>
