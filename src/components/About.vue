<template>
    <div>
        <h2>{{ $t("AboutUs") }}</h2>
        {{ $t("AboutUsText") }}

        <div class="developers">
            <div>
                <img :src="require('./../assets/alex.jpg')">
                <div class="name">
                    {{ $t("AlexKotliarov") }}
                </div>
                <small>
                    {{ $t("Programming") }}
                    <br><a href="https://www.facebook.com/kotl.alex" target="_blank">fb.me/kotl.alex</a>
                </small>
            </div>
            <div>
                <img :src="require('./../assets/alyona.jpg')">
                <div class="name">
                    {{ $t("AlyonaKotliarova") }}
                </div>
                <small>
                    {{ $t("IconsDesign") }}
                </small>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.developers {
    display: flex;
    text-align: center;
    margin-top: 30px;

    img {
        width: 70%;
        border-radius: 50%;
    }

    .name {
        font-weight: bold;
    }
}
</style>