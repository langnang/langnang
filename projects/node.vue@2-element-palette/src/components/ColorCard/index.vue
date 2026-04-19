<template>
	<el-row :gutter="20" style="margin-left: 0; margin-right: 0">
		<el-col
			:span="4"
			v-for="(palette, index) in palette_list"
			:key="index"
			class="el-col"
			:style="{
				position: 'relative',
			}"
		>
			<i
				:class="[
					is_select(palette.id) === true ? 'el-icon-success' : '',
				]"
				:style="{
					position: 'absolute',
					right: '5px',
					top: '5px',
					color: '#66b1ff',
				}"
			></i>
			<el-card
				v-if="palette.type === 'single'"
				class="el-card__palette"
				:style="{ 'background-color': palette.colors[0] }"
				@click.native="clickCard(palette.id)"
			>
			</el-card>
			<el-card
				v-else-if="palette.type === 'gradient'"
				class="el-card__palette"
				:style="{
					background: $gradient(palette.colors),
				}"
				@click.native="clickCard(palette.id)"
			>
			</el-card>
			<el-card
				v-else-if="palette.type === 'multi'"
				class="el-card__palette"
				@click.native="clickCard(palette.id)"
			>
				<span
					class="el-card__body-multi"
					v-for="color in palette.colors"
					:key="color"
					:style="{ 'background-color': color }"
				></span>
			</el-card>
			<div
				class="el-palette"
				:style="{
					'margin-top': '-24px',
					position: 'absolute',
					width: 'calc(100% - 20px)',
				}"
			>
				<el-button
					icon="el-icon-view"
					circle
					@click="showCarousel(index)"
				></el-button>
				<el-button
					icon="el-icon-edit"
					circle
					@click="editPalette(index)"
				></el-button>
				<el-popconfirm
					title="确定要删除吗"
					@onConfirm="deletePalette(index)"
					:style="{ margin: '0 10px' }"
				>
					<el-button
						icon="el-icon-delete"
						circle
						slot="reference"
					></el-button>
				</el-popconfirm>
				<el-button icon="el-icon-info" circle v-if="false"></el-button>
			</div>
		</el-col>
	</el-row>
</template>
<script>
	import { mapState, mapGetters } from "vuex";
	export default {
		data() {
			return {};
		},
		computed: {
			...mapState({
				palette_dialog: (state) => state.palette.dialog,
				palette_select: (state) => state.palette.select,
				palette_carousel: (state) => state.palette.carousel,
			}),
			...mapGetters(["palette_list"]),
		},
		methods: {
			editPalette(index) {
				this.palette_dialog.target = "update";
				this.palette_dialog.visible = true;
				this.$store.commit("setPaletteItem", index);
			},
			deletePalette(index) {
				this.$store.dispatch("deletePalette", index);
			},
			showCarousel(index) {
				this.palette_carousel.index = index;
				this.palette_carousel.visible = true;
			},
			clickCard(id) {
				const _index = this.palette_select.indexOf(id);
				if (_index == -1) {
					this.palette_select.push(id);
				} else {
					this.palette_select.splice(_index, 1);
				}
				this.palette_select.sort();
			},
			is_select(id) {
				return this.palette_select.filter((v) => v === id).length != 0
					? true
					: false;
			},
			downloadPalette(index) {
				console.log(index);
			},
		},
	};
</script>
<style lang="scss" scoped>
	::v-deep .el-col {
		padding: 10px 0;
		height: 150px;
		text-align: center;
	}
	// .box-card .el-card__body {
	// 	padding: 0 0 20px 0;
	// }
	// .box-card span {
	// 	display: none;
	// 	color: white;
	// }
	// .box-card:hover span {
	// 	display: block;
	// }
	::v-deep .el-button.is-circle {
		padding: 5px;
		font-size: 5px;
		display: none;
	}
	::v-deep .el-col:hover .el-button.is-circle {
		display: inline-block;
	}
</style>