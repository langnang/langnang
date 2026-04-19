<template>
    <el-row :gutter="20" style="margin-left:0;margin-right:0;">
        <h1>{{palette.name}}</h1>
        <el-col :span="6" class="el-col__color" v-for="(value,key) in palette.children" :key="key">
            <el-card class="el-card__color el-card__palette">
                <el-row :gutter="20" style="margin-left:0;margin-right:0;">
                    <el-col
                        :span="24 / value.colors.length"
                        class="el-col__color_piece"
                        v-for="(v,k) in value.colors"
                        :key="k"
                        :style="{'background-color':v}"
                    >{{v}}</el-col>
                </el-row>
            </el-card>
        </el-col>
    </el-row>
</template>

<script>
export default {
    data() {
        return {};
    },
    created() {
        this.$store.dispatch("loadChildren", {
            type: "palette",
            key: this.$route.params.key
        });
    },
    computed: {
        palette() {
            let _key = this.$route.params.key;
            return this.$store.getters.palette(_key);
        }
    },
    filters: {
        to_palette: v => {
            console.log(v);
        }
    }
};
</script>

<style scoped>
</style>