<template>
	<div class="home">
		<ColorCard />
	</div>
</template>

<script>
	import { mapState, mapGetters } from "vuex";
	import ColorCard from "@/components/ColorCard";
	export default {
		name: "Home",
		components: {
			ColorCard,
		},
		created() {
			// this.$store.dispatch("loadMenu");
		},
		computed: {
			...mapState({}),
			...mapGetters(["colors", "utils"]),
		},
	};
</script>
