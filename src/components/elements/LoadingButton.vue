<template>
    <button type="button" class="loading-button">
        <span v-if="loading">
            <div class="lds-dual-ring"></div>
            {{ $t("Loading") }}...
        </span>
        <span v-else>
            <slot></slot>
        </span>
    </button>
</template>

<script>
export default {
    props: {
        loading: {
            default: false
        }
    }
}
</script>

<style lang="scss" scoped>
    .loading-button {
        cursor: pointer;
        border: 0;
    }

    .lds-dual-ring {
        display: inline-block;
        vertical-align:middle;
        width: 32px;
        height: 32px;
        margin-right: 20px;
        margin-top: -8px;
    }
    .lds-dual-ring:after {
        content: " ";
        display: block;
        width: 20px;
        height: 20px;
        margin: 4px 4px;
        border-radius: 50%;
        border: 6px solid #fff;
        border-color: #fff transparent #fff transparent;
        animation: lds-dual-ring 1.2s linear infinite;
    }
    @keyframes lds-dual-ring {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

</style>
