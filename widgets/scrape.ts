import { writeFile } from 'fs/promises'
import puppeteer, { Page } from 'puppeteer'

type Movie = {
    title: string,
    release_date: Date | string,
    rating: number,
    director: string,
    image_url: string,
    popularity: number,
    pricing_per_day: number,
    sinopsis: string,
}
async function autoScroll(page: Page) {
   // https://stackoverflow.com/questions/51529332/puppeteer-scroll-down-until-you-cant-anymore 
    await page.evaluate(async () => {
        await new Promise((resolve) => {
            var totalHeight = 0;
            var distance = 960;
            var timer = setInterval(() => {
                var scrollHeight = document.body.scrollHeight;
                window.scrollBy(0, distance);
                totalHeight += distance;

                if(totalHeight >= scrollHeight - window.innerHeight){
                    clearInterval(timer);
                    resolve(null);
                }
            }, 100);
        });
    });
}
const MOVIES: Movie[] = []
// rating is floating 1 to 5, 1 being the worst
// popularity is integer 1 to n, 1 being the most popular
// make a function that generates renting pricing per day based on popularity and rating with normalized values
// make a clamp to values between 5 and 25
function generatePricing(popularity: number, rating: number) {
    console.log({ popularity, rating })
    const popularityNormalized = popularity / 10
    const ratingNormalized = rating / 5
    const pricing = popularityNormalized * ratingNormalized
    return Math.max(5, Math.min(25, pricing))
}
const sleep = (ms: number) => new Promise(resolve => setTimeout(resolve, ms))
const scrape = async () => {
    const browser = await puppeteer.launch({ headless: false })
    const page = await browser.newPage()
    page.setViewport({ width: 1920, height: 1080 })
    await page.goto('https://www.imdb.com/chart/moviemeter/?ref_=nv_mv_mpm')
    // scroll down to load more movies
    // for (let i = 0; i < 4; i++) {
    //     await page.evaluate(() => {
    //         window.scrollBy(0, window.innerHeight)
    //     })
    // }
    await autoScroll(page);
    // const data = await page.evaluate(async () => {
        let index = 1;
        const hrefs = [] as string[]
        const movies = []
        const elements = await page.$$('.ipc-metadata-list-summary-item')
        console.log({ elements })
        for (const element of elements) {
            if (!element) continue
            const href = await element.$eval('.ipc-title-link-wrapper', el => el.getAttribute('href'))
            if (!href) continue
            console.log({ href })
            hrefs.push(href) 
        }
        for (const href of hrefs) {
            await page.goto(`https://www.imdb.com/${href}`)
            await sleep(100)
            const title = await page.$eval('.hero__primary-text', el => el.textContent)
            const rating_element = (await page.$('[data-testid="hero-rating-bar__aggregate-rating__score"]'))
            //@ts-ignore
            const rating: string = rating_element ? await page.evaluate(el => el.textContent, rating_element) : '3'
            const director = (await page.$eval('[data-testid="title-pc-principal-credit"]', element => element.textContent))?.replace('Director:', '').replace('Directors:', '').trim().replace('Direção', '')
            //@ts-ignore
            const image_url = (await page.$eval('.ipc-image', el => el.src)) as string
            const sinopsis = (await page.$eval('[data-testid="plot-xs_to_m"]', element => element.textContent))?.replace('Director:', '').replace('Directors:', '').trim().replace('Direção', '')
            const popularity = await page.$eval(('[data-testid="hero-rating-bar__popularity__score"]'), el => el.textContent)
            // $('[data-testid="Details"]').querySelector('ul').querySelectorAll('*')[0].querySelectorAll('*')[1].textContent
            const release_date = (await page.$eval('[data-testid="Details"] ul li li', el => el.textContent))?.split('(')[0].trim()
            if (!title || !director || !image_url || !popularity || !sinopsis || !release_date) {
                console.log('missing data')
                continue
            }
            const pricing_per_day = generatePricing(Number(popularity), Number((rating.replace(',','.').split('/')[0] || 3)))
            MOVIES.push({
                title,
                release_date,
                rating: Number((rating.replace(',','.').split('/')[0] || 0)),
                director,
                image_url,
                popularity: Number(popularity),
                pricing_per_day,
                sinopsis,
            })
            console.log('Movie seeded', index)
            console.log({ rating: Number((rating.replace(',','.').split('/')[0] || 0)), popularity: Number(popularity), pricing_per_day })
            await writeFile('movies.json', JSON.stringify(MOVIES, null, 2))
            index++
        }
        await browser.close()
    // return data
}
scrape()