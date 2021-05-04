<?php
/**
 * The template for displaying front page
 */

get_header();
?>
<head><link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet"></head>

<template>
    <article>
        <h2 class="titel"></h2>
        <img src="" alt="" class="billede">
        <p class="genre"></p>
        <p class="episoder"></p>
        <p class="kort_beskrivelse"></p>
        <p class="lang_beskrivelse"></p>
        <p class="afsnit_titel"></p>
        <p class="dato"></p>
        <p class="afsnit_beskrivelse"></p>

    </article>
</template>

<section id="primary" class="content-area">
    <main id="main" class="site-main">
        <nav id="filtrering"></nav>
        <section id="liste">

        </section>
    </main><!-- #main -->

    <script>
        "use strict"
        console.log("hejbassemand");
        let podcasts;
        let categories;
        let filterPodcast = "alle";

        const dbUrl = "http://asoep.dk/Loud/wp-json/wp/v2/podcast?per_page=100";
        const catUrl = "http://asoep.dk/Loud/wp-json/wp/v2/categories";
        //
        //
        async function getJson() {
            const data = await fetch(dbUrl);
            const catdata = await fetch(catUrl);
            podcasts = await data.json();
            categories = await catdata.json();
            console.log("CATEGORIES", categories);
            visPodcasts();
            opretknapper();
        }
        //
        function opretknapper() {

            categories.forEach(cat => {
                document.querySelector("#filtrering").innerHTML += `<button class="filter" data-podcast="${cat.id}">${cat.name}</button>`;
            })
            addEventListenerToButtons();
        }

        function addEventListenerToButtons() {
            document.querySelectorAll("#filtrering button").forEach(elm => {
                elm.addEventListener("click", filtrering);
            })
        };

        function filtrering() {
            filterPodcast = this.dataset.podcast;
            console.log(filterPodcast);

            visPodcasts();
        }

        function visPodcasts() {
            let temp = document.querySelector("template");

            let container = document.querySelector("#liste");
            container.innerHTML = "";
            podcasts.forEach(podcast => {
                if (filterPodcast == "alle" || podcast.categories.includes(parseInt(filterPodcast))) {


                    let klon = temp.cloneNode(true).content;
                    // klon.querySelector(".titel").innerHTML = podcast.title.rendered;
                    klon.querySelector(".episoder").innerHTML = podcast.episoder + `${" episoder"}`;
                    klon.querySelector(".kort_beskrivelse").innerHTML = podcast.kort_beskrivelse;
                    klon.querySelector(".billede").src = podcast.billede.guid;
                    klon.querySelector("article").addEventListener("click", () => {
                        location.href = podcast.link;
                    })
                    container.appendChild(klon);
                }
            })
        }
        getJson();

    </script>
</section><!-- #primary -->

<?php
get_footer();
