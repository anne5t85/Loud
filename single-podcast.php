<?php
/**
 * The template for displaying front page
 */

get_header();
?>

<head>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
</head>
<div id="primary" class="single-area">
    <main id="main" class="single_view">

        <article id="venstre">
            <img src="" alt="" class="billede">
            <h2></h2>
            <p class="genre"></p>
            <p class="episoder"></p>
            <p class="kort_beskrivelse"></p>
            <p class="lang_beskrivelse"></p>
            <img src="" alt="icons" class="icons">

            <p class="dato"></p>
        </article>

        <section id="episoder">
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
        </section>
    </main><!-- #main -->

    <script>
        /* Her opstilles variabler*/
        let podcast;
        let episoder;

        /* denne variabel er nødvendig for at kunne opstille et single-view for den aktuelle podcast og dens tilhørende episoder*/
        /*den henter sloggens id (som er et tal) ved hjælp af php*/

        let aktuelpodcast = <?php echo get_the_ID() ?>;


        /*Her laver vi vores eget endpoint, hvor der peges på en podcast + dens tal*/
        const dbUrl = "http://asoep.dk/Loud/wp-json/wp/v2/podcast/" + aktuelpodcast;

        /*Her hentes alle podcasts episoderne ind */
        const episodeUrl = "http://asoep.dk/Loud/wp-json/wp/v2/episoder?per_page=100"

        /* Referere til section id i html, der hvor episoderne bliver placeret */
        const container = document.querySelector("#episoder");


        async function getJson() {
            /*Her fetcher vi den aktuelle podcast */
            const data = await fetch(dbUrl);
            podcast = await data.json();

            /*Her fetcher vi alle episoderne */
            const data2 = await fetch(episodeUrl);
            episoder = await data2.json();
            console.log("episoder: ", episoder);

            /*Her kaldes funktionerne */
            visPodcasts();
            visEpisoder();
        }

        /*Her udskrives informationerne til den aktuelle podcast i article */
        function visPodcasts() {
            document.querySelector("h2").innerHTML = podcast.title.rendered;
            document.querySelector(".lang_beskrivelse").innerHTML = podcast.lang_beskrivelse;
            document.querySelector(".dato").textContent = podcast.dato;
            document.querySelector(".billede").src = podcast.billede.guid;
            document.querySelector(".icons").src = podcast.icons.guid;

        }

        /*Her starter filtering af episoder*/
        function visEpisoder() {
            console.log("visEpisoder");

            /*Her udskrives informationerne i templaten */
            let temp = document.querySelector("template");

            /*Hvis episodens id hører til den aktuelle podcast skal de nedenstående informationer klones og udskrives.*/
            episoder.forEach(episode => {
                if (episode.horer_til_podcast[0].ID == aktuelpodcast) {

                    let klon = temp.cloneNode(true).content;
                    klon.querySelector(".dato").textContent = episode.dato;

                    klon.querySelector("h2").textContent = episode.title.rendered;

                    klon.querySelector(".kort_tekst").innerHTML = episode.kort_tekst;

                    klon.querySelector("article").addEventListener("click", () => {
                        location.href = episode.link;
                    })

                    klon.querySelector("button").href = episode.link;
                    console.log("episode", episode.link);
                    container.appendChild(klon);
                }
            })
        }
        getJson();

    </script>
</div><!-- #primary -->

<?php
get_footer();
