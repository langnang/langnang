<template>
	<div>
		<el-dialog
			title="调色板"
			:visible.sync="palette_dialog.visible"
			:close-on-press-escape="false"
			:close-on-click-modal="false"
			@closed="$store.commit('setPaletteItem')"
		>
			<el-form :model="palette" :rules="rules" ref="palette">
				<el-form-item label="名称" :label-width="labelWidth">
					<el-input
						v-model="palette.name"
						autocomplete="off"
					></el-input>
				</el-form-item>
				<el-form-item label="类别" :label-width="labelWidth">
					<el-select
						v-model="palette.type"
						placeholder="请选择颜色类别"
						style="display: block"
					>
						<el-option label="单色类" value="single"></el-option>
						<el-option label="渐变类" value="gradient"></el-option>
						<el-option label="多色类" value="multi"></el-option>
					</el-select>
				</el-form-item>
				<el-form-item
					label="单色"
					v-if="palette.type === 'single'"
					:label-width="labelWidth"
					:style="{
						height: '40px',
					}"
				>
					<el-color-picker
						v-model="palette.colors[0]"
					></el-color-picker>
				</el-form-item>
				<el-form-item
					label="渐变"
					v-if="palette.type === 'gradient'"
					:label-width="labelWidth"
					:style="{
						height: '40px',
					}"
				>
					<el-color-picker
						v-for="(color, index) in palette.colors"
						:key="index"
						v-model="palette.colors[index]"
					></el-color-picker>
					<el-button
						type="primary"
						icon="el-icon-plus"
						:style="{
							position: 'absolute',
							padding: '12px 8px',
						}"
						@click="$store.commit('addPaletteColor')"
					></el-button>
				</el-form-item>
				<el-form-item
					label="多色"
					v-if="palette.type === 'multi'"
					:label-width="labelWidth"
					:style="{
						height: '40px',
					}"
				>
					<el-color-picker
						v-for="(color, index) in palette.colors"
						:key="index"
						v-model="palette.colors[index]"
					></el-color-picker>
					<el-button
						type="primary"
						icon="el-icon-plus"
						:style="{
							position: 'absolute',
							padding: '12px 8px',
						}"
						@click="$store.commit('addPaletteColor')"
					></el-button>
				</el-form-item>
				<el-form-item label="预览" :label-width="labelWidth">
					<el-card
						class="el-card__palette"
						v-if="palette.type === 'single'"
						:style="{ 'background-color': palette.colors[0] }"
					>
					</el-card>
					<el-card
						class="el-card__palette"
						v-else-if="palette.type === 'gradient'"
						:style="{
							background: $gradient(palette.colors),
						}"
					>
					</el-card>
					<el-card
						class="el-card__palette"
						v-else-if="palette.type === 'multi'"
					>
						<span
							class="el-card__body-multi"
							v-for="color in palette.colors"
							:key="color"
							:style="{ 'background-color': color }"
						></span>
					</el-card>
				</el-form-item>
			</el-form>
			<div slot="footer" class="dialog-footer">
				<el-button @click="palette_dialog.visible = false">
					取 消
				</el-button>
				<el-button type="primary" @click="submit">确 定</el-button>
			</div>
		</el-dialog>
	</div>
</template>
<script>
	import { mapState, mapGetters } from "vuex";
	export default {
		data() {
			return {
				form: {},
				labelWidth: "100px",
				rules: {
					name: [
						{
							required: true,
							message: "请输入名称",
							trigger: "blur",
						},
					],
					type: [
						{
							required: true,
							message: "请选择类别",
							trigger: "change",
						},
					],
				},
			};
		},
		computed: {
			...mapState({
				palette: (state) => state.palette.item,
				palette_dialog: (state) => state.palette.dialog,
			}),
			...mapGetters([]),
		},
		methods: {
			addColor() {
				this.$store.mutations("addPaletteColor");
			},
			submit() {
				this.$refs["palette"].validate((valid) => {
					if (valid) {
						if (this.palette_dialog.target == "insert") {
							this.$store.dispatch("insertPalette");
						} else if (this.palette_dialog.target == "update") {
							this.$store.dispatch("updatePalette");
						}
						this.palette_dialog.visible = false;
					} else {
						console.log("error submit!!");
						return false;
					}
				});
			},
		},
	};
</script>

<style lang="scss" scoped>
	::v-deep .el-form-item__content {
		height: 40px;
	}
	::v-deep .el-color-picker__trigger {
		// height: 60px;
		// width: 60px;
		border: 0;
	}
	::v-deep .el-color-picker__color {
		border-radius: 50%;
	}
	::v-deep .el-color-picker__color-inner {
		border-radius: 50%;
	}
</style>