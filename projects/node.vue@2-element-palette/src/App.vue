<template>
	<div
		id="app"
		v-loading="user.loading"
		:element-loading-text="user.loading_text"
		:element-loading-spinner="user.loading_spinner"
	>
		<NavRow />
		<el-scrollbar style="height: calc(100vh - 61px)">
			<router-view />
		</el-scrollbar>
		<PaletteDialog />
		<PaletteCarouselDialog />
	</div>
</template>

<script>
	import NavRow from "@/components/NavRow";
	import PaletteDialog from "@/components/PaletteDialog";
	import PaletteCarouselDialog from "./components/PaletteCarouselDialog";
	import { mapState, mapGetters } from "vuex";
	import { list as palette_data_list } from "@/data/palette";
	import api from "@/api";
	export default {
		name: "app",
		components: {
			NavRow,
			PaletteDialog,
			PaletteCarouselDialog,
		},
		data() {
			return {
				drawer: {
					visible: false,
				},
			};
		},
		computed: {
			...mapState(["user", "palette", "palette_list"]),
			...mapState({}),
			...mapGetters(["refs"]),
		},
		created() {
			if (!api.palette.is()) {
				api.palette.create(palette_data_list());
			}
			this.$store.commit("setPaletteList", api.palette.list());
		},
		mounted() {},
	};
</script>

<style lang="scss">
	html,
	body {
		margin: 0;
		padding: 0;
		background-size: cover;
		-webkit-background-size: cover;
		-o-background-size: cover;
		background-position: center 0;
	}
	:focus {
		outline: 0;
	}
	#app {
		font-family: "Avenir", Helvetica, Arial, sans-serif;
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;
		color: #2c3e50;
	}
	h1 {
		margin-left: 8px;
	}
	.particles-js-canvas-el {
		position: fixed;
		top: 0;
		left: 0;
		z-index: -1;
	}
	.el-scrollbar__wrap {
		height: calc(100% + 17px) !important;
	}
	.el-loading-mask .el-icon-close {
		font-size: 40px;
	}
	.el-loading-spinner .path {
		stroke-width: 4px !important;
	}
	.el-tag {
		margin-left: 20px;
		height: unset !important;
		font-size: 18px !important;
		padding: 10px !important;
	}
	// .el-col__color {
	// 	border: 0px;
	// 	text-align: center;
	// 	padding: 10px;
	// }
	// .el-card__color {
	// 	display: flex;
	// 	justify-content: center;
	// 	align-items: center;
	// 	height: 150px;
	// 	border-radius: 10px !important;
	// 	border: 0px !important;
	// }
	// .el-card__color span {
	// 	display: none;
	// 	color: white;
	// }
	// .el-card__color:hover span {
	// 	display: block;
	// }
	.el-card__palette {
		height: 100%;
		border-radius: 10px;
		.el-card__body {
			width: 100%;
			height: 100%;
			padding: 0;
			display: flex;
		}
		.el-card__body-multi {
			display: inline-block;
			flex-grow: 1;
		}
	}
</style>
