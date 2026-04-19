<template>
    <el-row :gutter="20" style="margin-left:0;margin-right:0;">
        <h1>{{gradient.name}}</h1>
        <el-col :span="4" class="el-col__color" v-for="(value,key) in gradient.children" :key="key">
            <el-card class="el-card__color" :style="value | to_gradient">
                <span>{{value.name}}</span>
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
            type: "gradient",
            key: this.$route.params.key
        });
    },
    computed: {
        gradient() {
            let _key = this.$route.params.key;
            return this.$store.getters.gradient(_key);
        }
    },
    filters: {
        to_gradient: v => {
            let _direction = "to right";
            let _colors = v.colors.join(",");
            if (v.direction == "right") {
                _direction = "to right";
            }
            return {
                "background-image":
                    "linear-gradient(" + _direction + "," + _colors + ")"
            };
        }
    }
};
</script>

<style scoped>
.color-box {
    height: 150px;
}
.box-card {
    height: 150px;
    border-radius: 10px;
}
.box-card .el-card__body {
    padding: 0 0 20px 0;
}
</style>