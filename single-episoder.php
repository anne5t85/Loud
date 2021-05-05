<?php
/**
 * The template for displaying front page
 */

get_header();
?>
<head><link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet"></head>
<div id="primary" class="single-area">
    <main id="main" class="single_episode">
        <article id="venstre">
        <img src="" alt="podcasten" class="billede">
        <button>Tilbage</button>
        </article>

        <article id="hojre">
        <p class="dato"></p>
        <h2></h2>
            <p class="episoder"></p>
            <p class="kort_tekst"></p>
            <img src="" alt="playknap" class="player">
            <img src="" alt="ikonknap" class="ikoner">

        </article>

        <!-- <section id="episoder">
            <template>
                <article id="hojre">
                    <div>
                        <p class="dato"></p>
                        <h2></h2>
                        <p class="kort_tekst"></p>
                        <button class="epsiode_knap" href="">Lyt her</button>
                    </div>
                </article>
            </template>
        </section> -->
    </main><!-- #main -->

    <script>
        // let podcast;
        let episode;
        let aktuelepisode = <?php echo get_the_ID() ?>;

        const dbUrl = "http://asoep.dk/Loud/wp-json/wp/v2/episoder/" + aktuelepisode;
        // const episodeUrl = "http://asoep.dk/Loud/wp-json/wp/v2/episoder?per_page=100"

        const container = document.querySelector("#episoder");


        async function getJson() {
            const data = await fetch(dbUrl);
            episode = await data.json();

            // const data2 = await fetch(episodeUrl);
            // episoder = await data2.json();
            console.log("episoder: ", episode);
            // visPodcasts();
            visEpisode();
        }

        function visEpisode() {
            document.querySelector("h2").innerHTML = episode.title.rendered;
            document.querySelector(".kort_tekst").innerHTML = episode.kort_tekst;
            //            document.querySelector(".afsnit_titel").innerHTML = podcast.afsnit_titel;
            document.querySelector(".dato").textContent = episode.dato;
            //            document.querySelector(".afsnit_beskrivelse").innerHTML = podcast.afsnit_beskrivelse;
            document.querySelector(".billede").src = episode.billede.guid;
            document.querySelector(".player").src = episode.player.guid;
            document.querySelector(".ikoner").src = episode.ikoner.guid;
            document.querySelector("button").addEventListener("click", tilbageTilPodcast);
        }

        // function visEpisoder() {
        //     console.log("visEpisoder");
        //     let temp = document.querySelector("template");
        //     episoder.forEach(episode => {
        //         console.log("loop id :", aktuelpodcast);
        //         console.log("episode", episode);
        //          console.log("episode.horer_til_podcast",episode.horer_til_podcast);
        //          console.log("episode.horer_til_podcast",episode.horer_til_podcast[0].ID);
        //             console.log("loop kører id :", aktuelpodcast);
        //       if (episode.horer_til_podcast[0].ID == aktuelpodcast) {


        //             let klon = temp.cloneNode(true).content;
        //             klon.querySelector(".dato").textContent = episode.dato;

        //             klon.querySelector("h2").textContent = episode.title.rendered;

        //             klon.querySelector(".kort_tekst").innerHTML = episode.kort_tekst;

        //             klon.querySelector("article").addEventListener("click", () => {
        //                 location.href = episode.link;
        //             })

        //             klon.querySelector("button").href = episode.link;
        //            console.log("episode", episode.link);
        //             container.appendChild(klon);
        //      }
        //     })
        // }
        function tilbageTilPodcast(){
            console.log("hej", tilbageTilPodcast);
            history.back();
        }
        getJson();

    </script>
</div><!-- #primary -->

<?php
get_footer();
