-- Jogos mais jogados
select * from Collection order by numOfPlays desc

-- Top 5 mais jogados
select gameName from Collection order by numOfPlays desc limit 5

-- Partida com o maior número de jogadores
select * from plays order By numberOfPlayers desc,date asc, gameId desc

-- Quais jogos cada pessoa jogou
select distinct c.gameName
from points pts
JOIN players plr ON pts.playerId = plr.id
JOIN plays p ON p.playId = pts.playId
JOIN collection c ON c.bggId = p.gameId 
where plr.id = 4

-- Quantas vezes uma pessoa jogou cada jogo
select distinct c.gameName, count(p.playId) numberOfPlays
from points pts
JOIN players plr ON pts.playerId = plr.id
JOIN plays p ON p.playId = pts.playId
JOIN collection c ON c.bggId = p.gameId 
where plr.id = 4 group by p.gameId order by numberOfPlays desc

-- Quantas vezes uma pessoa ganhou cada jogo
select distinct c.gameName, count(p.playId) numberOfPlays
from points pts
JOIN players plr ON pts.playerId = plr.id
JOIN plays p ON p.playId = pts.playId
JOIN collection c ON c.bggId = p.gameId 
where plr.id = 4 and pts.winner=1 group by p.gameId order by numberOfPlays desc