import { Database } from 'bun:sqlite'

const db = new Database(process.cwd()+'/database/database.sqlite', { readwrite: true })
const data = await Bun.file(process.cwd()+'/widgets/movies.json').json()
let index = 1
const insert = db.prepare('INSERT INTO movies (title, release_date, rating, director, image_url, popularity, pricing_per_day, sinopsis, id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)')
const insertMovies = db.transaction((movies: any[]) => {
    for (const movie of movies) {
        insert.run(movie.title, movie.release_date, (movie.rating || 0), movie.director, movie.image_url, movie.popularity, movie.pricing_per_day, movie.sinopsis, index, new Date().toISOString(), new Date().toISOString())
        index++
    } 
    return movies.length    
})

const count = insertMovies(data)
