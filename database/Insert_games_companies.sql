-- Primero insertamos las compañías
INSERT INTO COMPAÑIAS (COMPAÑIA) VALUES 
('Activison Blizzard'),
('Axolot Games'),
('Bandai Namco'),
('Blobfish'),
('Bohemia Interactive'),
('CD PROJEKT RED'),
('Chiliroom'),
('Devolver Digital'),
('EA'),
('Epic Games'),
('Grinding Gear Games'),
('Habby'),
('Hi-Rez'),
('Innersloth'),
('Kinetic Games'),
('Maddy Makes Games'),
('Marvel'),
('MediaTonic'),
('Microsoft'),
('MiHoYo'),
('Mob Entertaiment'),
('Mobius Digital'),
('Mojang'),
('Ninja Wiki'),
('Nintendo'),
('Playrix'),
('Playstack'),
('Psyonix'),
('Re-Logic'),
('Riot Games'),
('Roblox Corporation'),
('Rockstar Games'),
('Scopely'),
('Sega'),
('SemiWork'),
('Sid Meier'),
('Smartly Dressed Games'),
('Sony'),
('StarBreeze'),
('Studio MDHR'),
('Studio Wildcard'),
('Supercell'),
('Team 17'),
('Team Cherry'),
('The India Stone'),
('The Pokemon Company'),
('Toby Fox'),
('Ubisoft'),
('Valve'),
('Wargaming'),
('Zeekerss');

-- Ahora insertamos los juegos, asociándolos con sus respectivas compañías
-- Para cada juego, necesitamos obtener el ID de la compañía correspondiente
-- Para simplificar, usaremos variables para guardar los IDs de las compañías

-- Activison Blizzard
SET @id_activision = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Activison Blizzard');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Call of Duty Black Ops 6', @id_activision, './assets/Games-logos/Activison-Blizzard/CODBO6.webp'),
('Crash Bandicot 4', @id_activision, './assets/Games-logos/Activison-Blizzard/CrashBandicot4-logo.webp'),
('Diablo', @id_activision, './assets/Games-logos/Activison-Blizzard/Diablo-logo.webp'),
('Hearthstone', @id_activision, './assets/Games-logos/Activison-Blizzard/Hearthstone-Logo.webp'),
('Overwatch', @id_activision, './assets/Games-logos/Activison-Blizzard/Overwatch-logo.webp'),
('StarCraft 2', @id_activision, './assets/Games-logos/Activison-Blizzard/StarCraft2-logo.webp'),
('World of Warcraft', @id_activision, './assets/Games-logos/Activison-Blizzard/WOW-logo.webp');

-- Axolot Games
SET @id_axolot = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Axolot Games');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Raft', @id_axolot, './assets/Games-logos/Axolot Games/Raft-logo.webp');

-- Bandai Namco
SET @id_bandai = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Bandai Namco');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Dark Souls', @id_bandai, './assets/Games-logos/Bandai Namco/DarkSouls-logo.webp'),
('Dragon Ball Z Budokai Tenkaichi', @id_bandai, './assets/Games-logos/Bandai Namco/DragonBallZBudokaiTenkaichi-logo.webp'),
('Pacman', @id_bandai, './assets/Games-logos/Bandai Namco/Pacman-logo.webp'),
('Tekken', @id_bandai, './assets/Games-logos/Bandai Namco/Tekken-logo.webp');

-- Blobfish
SET @id_blobfish = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Blobfish');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Brotato', @id_blobfish, './assets/Games-logos/Blobfish/Brotato-logo.webp');

-- Bohemia Interactive
SET @id_bohemia = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Bohemia Interactive');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('ARMA', @id_bohemia, './assets/Games-logos/Bohemia Interactive/ARMA-logo.webp'),
('DayZ', @id_bohemia, './assets/Games-logos/Bohemia Interactive/DayZ-logo.webp');

-- CD PROJEKT RED
SET @id_cdpr = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'CD PROJEKT RED');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Cyberpunk', @id_cdpr, './assets/Games-logos/CD PROJEKT RED/Cyberpunk-logo.webp'),
('The Witcher 3 Wild Hunt', @id_cdpr, './assets/Games-logos/CD PROJEKT RED/TheWitcher3WildHunt-logo.webp');

-- Chiliroom
SET @id_chiliroom = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Chiliroom');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Soul Knight', @id_chiliroom, './assets/Games-logos/Chiliroom/SoulKnight-logo.webp');

-- Devolver Digital
SET @id_devolver = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Devolver Digital');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Cult Of The Lamb', @id_devolver, './assets/Games-logos/Devolver Digital/CultOfTheLamb-logo.webp'),
('Enter The Gungeon', @id_devolver, './assets/Games-logos/Devolver Digital/EnterTheGungeon-logo.webp'),
('Hotline Miami', @id_devolver, './assets/Games-logos/Devolver Digital/HotlineMiami-logo.webp'),
('My Friend Pedro', @id_devolver, './assets/Games-logos/Devolver Digital/MyFriendPedro-logo.webp');

-- EA
SET @id_ea = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'EA');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Apex Legends', @id_ea, './assets/Games-logos/EA/ApexLegends-logo.webp'),
('A Way Out', @id_ea, './assets/Games-logos/EA/AWayOut-logo.webp'),
('Battlefield', @id_ea, './assets/Games-logos/EA/Battlefield-logo.webp'),
('F1 24', @id_ea, './assets/Games-logos/EA/F124-logo.webp'),
('FIFA', @id_ea, './assets/Games-logos/EA/Fifa-logo.webp'),
('It Takes Two', @id_ea, './assets/Games-logos/EA/ItTakesTwo-logo.webp'),
('Los Sims', @id_ea, './assets/Games-logos/EA/LosSims-logo.webp'),
('Mass Effect', @id_ea, './assets/Games-logos/EA/MassEffect-logo.webp'),
('Plants Vs Zombies', @id_ea, './assets/Games-logos/EA/PlantsVsZombies-logo.webp'),
('SimCity', @id_ea, './assets/Games-logos/EA/SimCity-logo.webp'),
('Spore', @id_ea, './assets/Games-logos/EA/Spore-logo.webp'),
('Star Wars Battlefront', @id_ea, './assets/Games-logos/EA/StarWarsBattlefront-logo.webp'),
('Titanfall', @id_ea, './assets/Games-logos/EA/Titanfall-logo.webp');

-- Epic Games
SET @id_epic = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Epic Games');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Fortnite', @id_epic, './assets/Games-logos/Epic Games/Fortnite-logo.webp'),
('Gears Of War', @id_epic, './assets/Games-logos/Epic Games/GearsOfWar-logo.webp'),
('Infinity Blade', @id_epic, './assets/Games-logos/Epic Games/InfinityBlade-logo.webp'),
('Unreal Tournament', @id_epic, './assets/Games-logos/Epic Games/UnrealTournament-logo.webp');

-- Grinding Gear Games
SET @id_ggg = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Grinding Gear Games');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Path Of Exile', @id_ggg, './assets/Games-logos/Grinding Gear Games/PathOfExile-logo.webp');

-- Habby
SET @id_habby = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Habby');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Archero 2', @id_habby, './assets/Games-logos/Habby/Archero2-logo.webp');

-- Hi-Rez
SET @id_hirez = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Hi-Rez');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Paladins', @id_hirez, './assets/Games-logos/Hi-Rez/Paladins-logo.webp'),
('Smite', @id_hirez, './assets/Games-logos/Hi-Rez/Smite-logo.webp');

-- Innersloth
SET @id_innersloth = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Innersloth');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Among Us', @id_innersloth, './assets/Games-logos/Innersloth/AmongUs-logo.webp');

-- Kinetic Games
SET @id_kinetic = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Kinetic Games');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Phasmophobia', @id_kinetic, './assets/Games-logos/Kinetic Games/Phasmophobia -logo.webp');

-- Maddy Makes Games
SET @id_maddy = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Maddy Makes Games');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Celeste', @id_maddy, './assets/Games-logos/Maddy Makes Games/Celeste-logo.webp');

-- Marvel
SET @id_marvel = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Marvel');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Marvel Rivals', @id_marvel, './assets/Games-logos/Marvel/MarvelRivals-logo.webp'),
('Marvel Snap', @id_marvel, './assets/Games-logos/Marvel/MarvelSnap-logo.webp'),
('Marvel Spiderman Miles Morales', @id_marvel, './assets/Games-logos/Marvel/MarvelSpidermanMilesMorales-logo.webp'),
('Marvel Strike Force', @id_marvel, './assets/Games-logos/Marvel/MarvelStrikeForce-logo.webp');

-- MediaTonic
SET @id_mediatonic = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'MediaTonic');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Fall Guys', @id_mediatonic, './assets/Games-logos/MediaTonic/FallGuys-logo.webp');

-- Microsoft
SET @id_microsoft = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Microsoft');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Age Of Empires', @id_microsoft, './assets/Games-logos/Microsoft/AgeOfEmpires-logo.webp'),
('Forza Horizon', @id_microsoft, './assets/Games-logos/Microsoft/ForzaHorizon-logo.webp'),
('Halo', @id_microsoft, './assets/Games-logos/Microsoft/Halo-logo.webp'),
('Microsoft Flight Simulator', @id_microsoft, './assets/Games-logos/Microsoft/MicrosoftFlightSimulator-logo.webp'),
('Sea Of Thieves', @id_microsoft, './assets/Games-logos/Microsoft/SeaOfThieves-logo.webp');

-- MiHoYo
SET @id_mihoyo = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'MiHoYo');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Genshin Impact', @id_mihoyo, './assets/Games-logos/MiHoYo/GenshinImpact-logo.webp'),
('Honkai Impact 3D', @id_mihoyo, './assets/Games-logos/MiHoYo/HonkaiImpact3D-logo.webp'),
('Honkai Star Rail', @id_mihoyo, './assets/Games-logos/MiHoYo/HonkaiStarRail-logo.webp'),
('Tears Of Themis', @id_mihoyo, './assets/Games-logos/MiHoYo/TearsOfThemis-logo.webp'),
('Zenless Zone Zero', @id_mihoyo, './assets/Games-logos/MiHoYo/ZenlessZoneZero-logo.webp');

-- Mob Entertaiment
SET @id_mob = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Mob Entertaiment');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Poppy Playtime', @id_mob, './assets/Games-logos/Mob Entertaiment/PoppyPlaytime-logo.webp');

-- Mobius Digital
SET @id_mobius = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Mobius Digital');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Outer Wilds', @id_mobius, './assets/Games-logos/Mobius Digital/OuterWilds-logo.webp');

-- Mojang
SET @id_mojang = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Mojang');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Minecraft', @id_mojang, './assets/Games-logos/Mojang/Minecraft-logo.webp');

-- Ninja Wiki
SET @id_ninja = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Ninja Wiki');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Bloons TD 6', @id_ninja, './assets/Games-logos/Ninja Wiki/BloonsTD6-logo.webp');

-- Nintendo
SET @id_nintendo = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Nintendo');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Animal Crossing New Horizons', @id_nintendo, './assets/Games-logos/Nintendo/AnimalCrossingNewHorizons-logo.webp'),
('Mario Kart 8 Deluxe', @id_nintendo, './assets/Games-logos/Nintendo/MarioKart8Deluxe-logo.webp'),
('Splatoon', @id_nintendo, './assets/Games-logos/Nintendo/Splatoon-logo.webp'),
('Super Mario Bros Wonder', @id_nintendo, './assets/Games-logos/Nintendo/SuperMarioBrosWonder-logo.webp'),
('Super Mario Maker', @id_nintendo, './assets/Games-logos/Nintendo/SuperMarioMaker-logo.webp'),
('Super Mario Odyssey', @id_nintendo, './assets/Games-logos/Nintendo/SuperMarioOdyssey-logo.webp'),
('Zelda Breath Of The Wild', @id_nintendo, './assets/Games-logos/Nintendo/ZeldaBreathOfTheWild-logo.webp');

-- Playrix
SET @id_playrix = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Playrix');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Fishdom', @id_playrix, './assets/Games-logos/Playrix/Fishdom-logo.webp'),
('Gardenscapes', @id_playrix, './assets/Games-logos/Playrix/Gardenscapes-logo.webp'),
('Homescapes', @id_playrix, './assets/Games-logos/Playrix/Homescapes-logo.webp'),
('Township', @id_playrix, './assets/Games-logos/Playrix/Township-logo.webp');

-- Playstack
SET @id_playstack = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Playstack');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Balatro', @id_playstack, './assets/Games-logos/Playstack/Balatro-logo.webp');

-- Psyonix
SET @id_psyonix = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Psyonix');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Rocket League', @id_psyonix, './assets/Games-logos/Psyonix/RocketLeague-logo.webp');

-- Re-Logic
SET @id_relogic = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Re-Logic');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Terraria', @id_relogic, './assets/Games-logos/Re-Logic/Terraria-logo.webp');

-- Riot Games (corregir el nombre que en la carpeta es Riot_Games)
SET @id_riot = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Riot Games');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Legends Of Runeterra', @id_riot, './assets/Games-logos/Riot_Games/LegendsOfRuneterra-logo.webp'),
('League of Legends', @id_riot, './assets/Games-logos/Riot_Games/lol-logo.webp'),
('Teamfight Tactics', @id_riot, './assets/Games-logos/Riot_Games/tft-logo.webp'),
('Valorant', @id_riot, './assets/Games-logos/Riot_Games/valorant-logo.webp');

-- Roblox Corporation
SET @id_roblox = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Roblox Corporation');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Roblox', @id_roblox, './assets/Games-logos/Roblox Corporation/Roblox-logo.webp');

-- Rockstar Games
SET @id_rockstar = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Rockstar Games');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Grand Theft Auto V', @id_rockstar, './assets/Games-logos/Rockstar Games/gta5-logo.webp'),
('Red Dead Redemption 2', @id_rockstar, './assets/Games-logos/Rockstar Games/rdr2-logo.webp');

-- Scopely
SET @id_scopely = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Scopely');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Monopoly GO', @id_scopely, './assets/Games-logos/Scopely/MonopolyGO-logo.webp'),
('Stumble Guys', @id_scopely, './assets/Games-logos/Scopely/StumbleGuys-logo.webp');

-- Sega
SET @id_sega = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Sega');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Persona', @id_sega, './assets/Games-logos/Sega/Persona-logo.webp'),
('Sonic', @id_sega, './assets/Games-logos/Sega/Sonic-logo.webp'),
('Total War', @id_sega, './assets/Games-logos/Sega/TotalWar-logo.webp'),
('Yakuza', @id_sega, './assets/Games-logos/Sega/Yakuza-logo.webp');

-- SemiWork
SET @id_semiwork = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'SemiWork');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('REPO', @id_semiwork, './assets/Games-logos/SemiWork/REPO-logo.webp');

-- Sid Meier
SET @id_sid = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Sid Meier');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Civilization I', @id_sid, './assets/Games-logos/Sid Meier/Civilization I-logo.webp'),
('Civilization VII', @id_sid, './assets/Games-logos/Sid Meier/Civilization VII-logo.webp');

-- Smartly Dressed Games
SET @id_smartly = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Smartly Dressed Games');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Unturned', @id_smartly, './assets/Games-logos/Smartly Dressed Games/Unturned-logo.webp');

-- Sony
SET @id_sony = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Sony');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('God Of War', @id_sony, './assets/Games-logos/Sony/GodOfWar-logo.webp'),
('Gran Turismo', @id_sony, './assets/Games-logos/Sony/GranTurismo-logo.webp'),
('The Last Of Us', @id_sony, './assets/Games-logos/Sony/TheLastOfUs-logo.webp'),
('Uncharted', @id_sony, './assets/Games-logos/Sony/Uncharted-logo.webp');

-- StarBreeze
SET @id_starbreeze = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'StarBreeze');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Payday', @id_starbreeze, './assets/Games-logos/StarBreeze/Payday-logo.webp');

-- Studio MDHR
SET @id_mdhr = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Studio MDHR');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Cuphead', @id_mdhr, './assets/Games-logos/Studio MDHR/Cuphead-logo.webp');

-- Studio Wildcard
SET @id_wildcard = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Studio Wildcard');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Ark', @id_wildcard, './assets/Games-logos/Studio Wildcard/Ark-logo.webp');

-- Supercell
SET @id_supercell = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Supercell');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Boom Beach', @id_supercell, './assets/Games-logos/Supercell/BoomBeach-logo.webp'),
('Brawl Stars', @id_supercell, './assets/Games-logos/Supercell/BrawlStars-logo.webp'),
('Clash Of Clans', @id_supercell, './assets/Games-logos/Supercell/ClashOfClans-logo.webp'),
('Clash Royale', @id_supercell, './assets/Games-logos/Supercell/ClashRoyale-logo.webp'),
('Hay Day', @id_supercell, './assets/Games-logos/Supercell/HayDay-logo.webp'),
('Mo.co', @id_supercell, './assets/Games-logos/Supercell/Mo.co-logo.webp'),
('Squad Busters', @id_supercell, './assets/Games-logos/Supercell/SquadBusters-logo.webp');

-- Team 17
SET @id_team17 = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Team 17');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Blasphemous', @id_team17, './assets/Games-logos/Team 17/Blasphemous-logo.webp'),
('Overcooked', @id_team17, './assets/Games-logos/Team 17/Overcooked-logo.webp');

-- Team Cherry
SET @id_cherry = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Team Cherry');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Hollow Knight', @id_cherry, './assets/Games-logos/Team Cherry/HollowKnight-logo.webp');

-- The India Stone
SET @id_india = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'The India Stone');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Project Zomboid', @id_india, './assets/Games-logos/The India Stone/ProjectZomboid-logo.webp');

-- The Pokemon Company
SET @id_pokemon = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'The Pokemon Company');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Pokemon Cafe', @id_pokemon, './assets/Games-logos/The Pokemon Company/PokemonCafe-logo.webp'),
('Pokemon GO', @id_pokemon, './assets/Games-logos/The Pokemon Company/PokemonGO-logo.webp'),
('Pokemon TCG Pocket', @id_pokemon, './assets/Games-logos/The Pokemon Company/PokemonTCGPocket-logo.webp'),
('Pokemon Trading Card Game', @id_pokemon, './assets/Games-logos/The Pokemon Company/PokémonTradingCardGame-logo.webp');

-- Toby Fox
SET @id_toby = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Toby Fox');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Undertale', @id_toby, './assets/Games-logos/Toby Fox/Undertale-logo.webp');

-- Ubisoft
SET @id_ubisoft = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Ubisoft');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Assassins Creed', @id_ubisoft, './assets/Games-logos/Ubisoft/AssassinsCreed-logo.webp'),
('Far Cry 6', @id_ubisoft, './assets/Games-logos/Ubisoft/FarCry6-logo.webp'),
('Rainbow Six Siege', @id_ubisoft, './assets/Games-logos/Ubisoft/RainbowSixSiege-logo.webp'),
('The Division 2', @id_ubisoft, './assets/Games-logos/Ubisoft/TheDivision2-logo.webp'),
('Trackmania', @id_ubisoft, './assets/Games-logos/Ubisoft/Trackmania-logo.webp'),
('Watch Dogs Legion', @id_ubisoft, './assets/Games-logos/Ubisoft/WatchDogsLegion-logo.webp');

-- Valve
SET @id_valve = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Valve');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Counter Strike Global Offensive', @id_valve, './assets/Games-logos/Valve/CSGO-logo.webp'),
('Dota 2', @id_valve, './assets/Games-logos/Valve/Dota2-logo.webp'),
('Half Life', @id_valve, './assets/Games-logos/Valve/HalfLife-logo.webp'),
('Left 4 Dead', @id_valve, './assets/Games-logos/Valve/Left4Dead-logo.webp'),
('Portal', @id_valve, './assets/Games-logos/Valve/Portal-logo.webp'),
('Team Fortress', @id_valve, './assets/Games-logos/Valve/TeamFortress-logo.webp');

-- Wargaming
SET @id_wargaming = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Wargaming');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('World Of Warships', @id_wargaming, './assets/Games-logos/Wargaming/WorldOfWarships-logo.webp');

-- Zeekerss
SET @id_zeekerss = (SELECT ID_COMPAÑIA FROM COMPAÑIAS WHERE COMPAÑIA = 'Zeekerss');
INSERT INTO JUEGOS (JUEGO, ID_COMPAÑIA, URL_IMAGEN) VALUES 
('Lethal Company', @id_zeekerss, './assets/Games-logos/Zeekerss/LethalCompany-logo.webp');

-- Ahora, vamos a asignar algunas categorías a los juegos basándonos en su género común
-- Esto es opcional, pero mejorará la base de datos con información adicional

-- Asignar categorías a algunos juegos populares
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO IN ('Call of Duty Black Ops 6', 'Overwatch', 'Apex Legends', 'Valorant', 'Counter Strike Global Offensive', 'Rainbow Six Siege');

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'MOBA') 
WHERE JUEGO IN ('League of Legends', 'Dota 2', 'Smite');

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'RPG') 
WHERE JUEGO IN ('The Witcher 3 Wild Hunt', 'Diablo', 'World of Warcraft', 'Cyberpunk', 'Mass Effect', 'Undertale');

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Battle Royale') 
WHERE JUEGO IN ('Fortnite', 'Apex Legends');

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Estrategia') 
WHERE JUEGO IN ('Age Of Empires', 'Civilization I', 'Civilization VII', 'StarCraft 2', 'Total War');

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Sandbox') 
WHERE JUEGO IN ('Minecraft', 'Terraria');

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Mundo abierto') 
WHERE JUEGO IN ('Grand Theft Auto V', 'Red Dead Redemption 2', 'The Witcher 3 Wild Hunt', 'Cyberpunk', 'Zelda Breath Of The Wild');

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Deportes') 
WHERE JUEGO IN ('FIFA', 'Rocket League', 'F1 24');

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Survival Horror') 
WHERE JUEGO IN ('DayZ', 'Project Zomboid', 'Phasmophobia');

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Plataformas') 
WHERE JUEGO IN ('Crash Bandicot 4', 'Super Mario Bros Wonder', 'Super Mario Odyssey', 'Hollow Knight', 'Celeste');

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Card Game') 
WHERE JUEGO IN ('Hearthstone', 'Marvel Snap', 'Legends Of Runeterra', 'Pokemon Trading Card Game');

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Roguelike') 
WHERE JUEGO IN ('Enter The Gungeon', 'Cult Of The Lamb', 'Brotato');

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Fighting') 
WHERE JUEGO IN ('Tekken', 'Dragon Ball Z Budokai Tenkaichi');

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Acción') 
WHERE JUEGO IN ('God Of War', 'Assassins Creed', 'Gears Of War', 'Uncharted', 'Hotline Miami');

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Simulación') 
WHERE JUEGO IN ('Los Sims', 'Microsoft Flight Simulator', 'SimCity');

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Aventura') 
WHERE JUEGO IN ('It Takes Two', 'A Way Out', 'Outer Wilds', 'The Last Of Us');

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'MMORPG') 
WHERE JUEGO IN ('World of Warcraft', 'Genshin Impact');

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Indie') 
WHERE JUEGO IN ('Hollow Knight', 'Cuphead', 'Undertale', 'Celeste', 'Balatro', 'Raft', 'Brotato', 'Fall Guys');

-- Añadir algunas descripciones para los juegos más populares
UPDATE JUEGOS SET DESCRIPCION = 'Un Battle Royale gratuito donde 100 jugadores luchan para ser el último en pie. Construye, lucha y sobrevive en un mundo colorido lleno de desafíos.' 
WHERE JUEGO = 'Fortnite';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de mundo abierto donde puedes construir prácticamente cualquier cosa que puedas imaginar utilizando bloques. Sobrevive, explora y crea en un mundo infinito.' 
WHERE JUEGO = 'Minecraft';

UPDATE JUEGOS SET DESCRIPCION = 'Un shooter táctico 5v5 basado en personajes donde la precisión, el trabajo en equipo y las habilidades determinan la victoria.' 
WHERE JUEGO = 'Valorant';

UPDATE JUEGOS SET DESCRIPCION = 'Un MOBA 5v5 donde dos equipos compiten por destruir la base enemiga. Con más de 140 campeones para elegir, cada partida es única.' 
WHERE JUEGO = 'League of Legends';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de mundo abierto ambientado en un futuro distópico donde la tecnología y la corporatividad dominan la sociedad.' 
WHERE JUEGO = 'Cyberpunk';

UPDATE JUEGOS SET DESCRIPCION = 'Explora un vasto mundo abierto como Geralt de Rivia, un cazador de monstruos. Combate, magia y una narrativa profunda en un mundo medieval fantástico.' 
WHERE JUEGO = 'The Witcher 3 Wild Hunt';

UPDATE JUEGOS SET DESCRIPCION = 'Experimenta la última entrega de la icónica serie Grand Theft Auto en la vibrante ciudad de Los Santos. Crimen, acción y libertad en un mundo abierto sin igual.' 
WHERE JUEGO = 'Grand Theft Auto V';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de aventuras donde cazas fantasmas con hasta tres amigos. Utiliza equipo para detectar actividad paranormal y completa objetivos en localizaciones embrujadas.' 
WHERE JUEGO = 'Phasmophobia';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego roguelike de acción y disparos donde debes descender a la "Mazmorra" para encontrar el arma que puede matar el pasado.' 
WHERE JUEGO = 'Enter The Gungeon';

UPDATE JUEGOS SET DESCRIPCION = 'El MMORPG más popular del mundo. Explora el vasto mundo de Azeroth, completa misiones, participa en mazmorras y raids con amigos.' 
WHERE JUEGO = 'World of Warcraft';

UPDATE JUEGOS SET DESCRIPCION = 'Explora, lucha y construye en un mundo 2D generado proceduralmente lleno de aventuras y peligros.' 
WHERE JUEGO = 'Terraria';

UPDATE JUEGOS SET DESCRIPCION = 'Un Battle Royale con héroes únicos, cada uno con habilidades especiales. Combina movimiento fluido y tiroteos tácticos.' 
WHERE JUEGO = 'Apex Legends';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de fútbol donde controlas coches potenciados para meter un balón gigante en la portería rival. Simple en concepto, difícil de dominar.' 
WHERE JUEGO = 'Rocket League';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de aventuras en una isla misteriosa atrapada en un bucle temporal. Explora, resuelve enigmas y descubre los secretos del universo.' 
WHERE JUEGO = 'Outer Wilds';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego cooperativo donde un equipo de trabajadores recoge chatarra en lunas peligrosas para cumplir con sus cuotas corporativas. Terror, supervivencia y trabajo en equipo.' 
WHERE JUEGO = 'Lethal Company';

-- Actualización de descripciones para juegos de Activison Blizzard
UPDATE JUEGOS SET DESCRIPCION = 'La sexta entrega de la serie Black Ops de Call of Duty. Un shooter en primera persona con modo campaña, multijugador y zombies en un entorno de Guerra Fría.' 
WHERE JUEGO = 'Call of Duty Black Ops 6';

UPDATE JUEGOS SET DESCRIPCION = 'Una aventura de plataformas protagonizada por el icónico marsupial naranja. Supera niveles desafiantes, recoge frutas Wumpa y derrota a los secuaces del Dr. Neo Cortex.' 
WHERE JUEGO = 'Crash Bandicot 4';

UPDATE JUEGOS SET DESCRIPCION = 'Un RPG de acción ambientado en un mundo oscuro de fantasía. Combate contra hordas de demonios, mejora tu equipo y descubre los secretos de Santuario.' 
WHERE JUEGO = 'Diablo';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de cartas coleccionables digital ambientado en el universo de Warcraft. Construye mazos estratégicos, invoca criaturas y lanza hechizos para derrotar a tus oponentes.' 
WHERE JUEGO = 'Hearthstone';

UPDATE JUEGOS SET DESCRIPCION = 'Un shooter en primera persona por equipos con héroes únicos, cada uno con habilidades y roles específicos. Trabaja en equipo para asegurar objetivos y derrotar al equipo contrario.' 
WHERE JUEGO = 'Overwatch';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de estrategia en tiempo real ambientado en un universo de ciencia ficción. Controla una de las tres razas: Terran, Zerg o Protoss, y compite por la supremacía galáctica.' 
WHERE JUEGO = 'StarCraft 2';

-- Axolot Games
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de supervivencia en alta mar donde construyes tu propia balsa. Navega, recoge recursos, expande tu balsa y explora islas mientras evitas los peligros del océano.' 
WHERE JUEGO = 'Raft';

-- Bandai Namco
UPDATE JUEGOS SET DESCRIPCION = 'Un desafiante RPG de acción en tercera persona conocido por su dificultad. Explora un mundo oscuro y desolado, enfrenta jefes épicos y descubre una rica narrativa ambiental.' 
WHERE JUEGO = 'Dark Souls';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de lucha basado en la popular serie de anime Dragon Ball. Participa en batallas 3D espectaculares con tus personajes favoritos y desata ataques devastadores.' 
WHERE JUEGO = 'Dragon Ball Z Budokai Tenkaichi';

UPDATE JUEGOS SET DESCRIPCION = 'El clásico arcade donde controlas a Pac-Man para comer todas las pastillas del laberinto mientras evitas a los fantasmas. Simple pero adictivo.' 
WHERE JUEGO = 'Pacman';

UPDATE JUEGOS SET DESCRIPCION = 'Una serie de juegos de lucha con combates técnicos y personajes icónicos. Domina combinaciones de golpes, patadas y técnicas especiales para derrotar a tus oponentes.' 
WHERE JUEGO = 'Tekken';

-- Blobfish
UPDATE JUEGOS SET DESCRIPCION = 'Un roguelike de acción y supervivencia donde controlas una patata mutante que lucha contra hordas de enemigos. Combina armas y mejoras para crear builds únicos en cada partida.' 
WHERE JUEGO = 'Brotato';

-- Bohemia Interactive
UPDATE JUEGOS SET DESCRIPCION = 'Un simulador militar realista que enfatiza el combate táctico, la planificación estratégica y la coordinación de equipo. Ofrece vastos campos de batalla y un sistema de juego detallado.' 
WHERE JUEGO = 'ARMA';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de supervivencia en mundo abierto ambientado en un apocalipsis zombie. Busca recursos, construye refugios y sobrevive tanto a los infectados como a otros jugadores.' 
WHERE JUEGO = 'DayZ';

-- Chiliroom
UPDATE JUEGOS SET DESCRIPCION = 'Un roguelike de acción para móviles donde exploras mazmorras generadas aleatoriamente, recoges armas mágicas y luchas contra hordas de enemigos con personajes únicos.' 
WHERE JUEGO = 'Soul Knight';

-- Devolver Digital
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de gestión y acción donde lideras un culto de adoradores de corderos. Construye tu base, adoctrina seguidores y embárcate en misiones para derrotar a falsos profetas.' 
WHERE JUEGO = 'Cult Of The Lamb';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de acción y disparos en 2D con estilo neo-noir ambientado en Miami. Completa misiones violentas con una jugabilidad rápida y brutal en escenarios coloridos.' 
WHERE JUEGO = 'Hotline Miami';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de acción y plataformas donde controlas a un ex-sicario convertido en plátano que busca venganza. Realiza acrobacias en cámara lenta mientras eliminas enemigos con estilo.' 
WHERE JUEGO = 'My Friend Pedro';

-- EA (los que faltan)
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de acción-aventura cooperativo donde dos prisioneros deben trabajar juntos para escapar de la cárcel. Requiere coordinación y resolución de problemas en equipo.' 
WHERE JUEGO = 'A Way Out';

UPDATE JUEGOS SET DESCRIPCION = 'Una serie de shooters en primera persona con énfasis en combates a gran escala, vehículos y entornos destructibles. Ofrece intensas batallas multijugador.' 
WHERE JUEGO = 'Battlefield';

UPDATE JUEGOS SET DESCRIPCION = 'El simulador oficial del Campeonato Mundial de Fórmula 1. Compite con equipos y pilotos reales en circuitos de todo el mundo con un realismo impresionante.' 
WHERE JUEGO = 'F1 24';

UPDATE JUEGOS SET DESCRIPCION = 'La serie de simulación de fútbol más popular del mundo. Juega con equipos y jugadores reales, compite en torneos internacionales y vive la emoción del deporte rey.' 
WHERE JUEGO = 'FIFA';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego cooperativo de aventuras y plataformas donde una pareja debe colaborar para superar desafíos mágicos y salvar su relación. Ganador de múltiples premios GOTY.' 
WHERE JUEGO = 'It Takes Two';

UPDATE JUEGOS SET DESCRIPCION = 'Un simulador de vida donde puedes crear y controlar personas virtuales. Construye casas, forma familias y guía a tus Sims a través de sus vidas.' 
WHERE JUEGO = 'Los Sims';

UPDATE JUEGOS SET DESCRIPCION = 'Una saga de RPG de ciencia ficción donde tus decisiones afectan la historia. Explora la galaxia, forma un equipo de especialistas y enfrenta amenazas cósmicas.' 
WHERE JUEGO = 'Mass Effect';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de tower defense donde plantas diferentes tipos de vegetales para defender tu jardín de una invasión de zombies divertidos pero peligrosos.' 
WHERE JUEGO = 'Plants Vs Zombies';

UPDATE JUEGOS SET DESCRIPCION = 'Un simulador de ciudad donde planificas, construyes y gestionas tu propia metrópolis. Controla zonificación, infraestructuras y servicios públicos para crear la ciudad perfecta.' 
WHERE JUEGO = 'SimCity';

UPDATE JUEGOS SET DESCRIPCION = 'Un simulador de evolución donde guías a una especie desde la etapa celular hasta la conquista espacial. Diseña criaturas, forma tribus y construye civilizaciones.' 
WHERE JUEGO = 'Spore';

UPDATE JUEGOS SET DESCRIPCION = 'Un shooter en primera persona ambientado en el universo de Star Wars. Participa en épicas batallas multijugador en planetas icónicos con héroes y villanos de la saga.' 
WHERE JUEGO = 'Star Wars Battlefront';

UPDATE JUEGOS SET DESCRIPCION = 'Un shooter futurista en primera persona con mechas gigantes. Combina el parkour fluido de los pilotos con el poder de los titanes para dominar el campo de batalla.' 
WHERE JUEGO = 'Titanfall';

-- Epic Games
UPDATE JUEGOS SET DESCRIPCION = 'Una saga de shooters en tercera persona con énfasis en el combate cuerpo a cuerpo con motosierras. Lucha contra la amenaza Locust en un mundo devastado por la guerra.' 
WHERE JUEGO = 'Gears Of War';

UPDATE JUEGOS SET DESCRIPCION = 'Una serie de juegos de acción RPG para móviles con gráficos impresionantes. Explora un mundo fantástico, mejora tu equipamiento y enfrenta enemigos poderosos.' 
WHERE JUEGO = 'Infinity Blade';

UPDATE JUEGOS SET DESCRIPCION = 'Un shooter en primera persona de ritmo rápido centrado en la destreza y los reflejos. Compite en arenas frenéticas con un arsenal diverso y modos de juego variados.' 
WHERE JUEGO = 'Unreal Tournament';

-- Grinding Gear Games
UPDATE JUEGOS SET DESCRIPCION = 'Un ARPG gratuito con un sistema de habilidades y personalización extremadamente profundo. Elige entre siete clases y personaliza tu personaje con un árbol de habilidades masivo.' 
WHERE JUEGO = 'Path Of Exile';

-- Habby
UPDATE JUEGOS SET DESCRIPCION = 'Secuela del popular juego de arqueros para móviles. Supera niveles generados aleatoriamente, mejora tus habilidades y equipo mientras enfrentas jefes desafiantes.' 
WHERE JUEGO = 'Archero 2';

-- Hi-Rez
UPDATE JUEGOS SET DESCRIPCION = 'Un shooter en primera persona por equipos con elementos de héroe. Selecciona campeones con habilidades únicas y compite en intensos enfrentamientos por objetivos.' 
WHERE JUEGO = 'Paladins';

-- Innersloth
UPDATE JUEGOS SET DESCRIPCION = 'Un juego multijugador de deducción social donde los tripulantes deben identificar a los impostores antes de que saboteen la nave. Cooperación, engaño y deducción.' 
WHERE JUEGO = 'Among Us';

-- Maddy Makes Games
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de plataformas preciso y desafiante sobre una joven que intenta escalar una montaña. Supera obstáculos cada vez más difíciles mientras descubres una historia emocional.' 
WHERE JUEGO = 'Celeste';

-- Marvel
UPDATE JUEGOS SET DESCRIPCION = 'Un shooter en tercera persona de héroe con personajes del universo Marvel. Forma equipos de tres y compite en intensas batallas por objetivos.' 
WHERE JUEGO = 'Marvel Rivals';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de cartas coleccionables digital con héroes y villanos de Marvel. Partidas rápidas de 3 minutos con mecánicas estratégicas y gráficos coloridos.' 
WHERE JUEGO = 'Marvel Snap';

UPDATE JUEGOS SET DESCRIPCION = 'Una aventura de acción en tercera persona donde controlas a Miles Morales, el nuevo Spider-Man. Balancéate por Nueva York y protege la ciudad con tus poderes únicos.' 
WHERE JUEGO = 'Marvel Spiderman Miles Morales';

UPDATE JUEGOS SET DESCRIPCION = 'Un RPG de colección de personajes para móviles con héroes y villanos del universo Marvel. Forma equipos, mejora tus personajes y compite en diversos modos de juego.' 
WHERE JUEGO = 'Marvel Strike Force';

-- MediaTonic
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de battle royale desenfadado donde 60 jugadores compiten en divertidos minijuegos con personajes con forma de frijol. Divertido, colorido y accesible para todos.' 
WHERE JUEGO = 'Fall Guys';

-- Microsoft
UPDATE JUEGOS SET DESCRIPCION = 'Una serie de juegos de estrategia en tiempo real ambientada en diferentes épocas históricas. Construye imperios, gestiona recursos y conquista a tus enemigos.' 
WHERE JUEGO = 'Age Of Empires';

UPDATE JUEGOS SET DESCRIPCION = 'Un simulador de conducción en mundo abierto. Explora entornos detallados, colecciona cientos de vehículos y participa en diversos eventos de carreras.' 
WHERE JUEGO = 'Forza Horizon';

UPDATE JUEGOS SET DESCRIPCION = 'Una serie icónica de shooters en primera persona que sigue la historia del Master Chief. Combate contra alienígenas, disfruta del multijugador competitivo y cooperativo.' 
WHERE JUEGO = 'Halo';

UPDATE JUEGOS SET DESCRIPCION = 'Un simulador de vuelo ultra realista que recrea la Tierra con datos de satélite. Pilota diversos aviones desde cabinas detalladas y vuela a cualquier parte del mundo.' 
WHERE JUEGO = 'Microsoft Flight Simulator';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de aventuras de mundo abierto ambientado en mares caribeños. Conviértete en pirata, navega por los océanos, busca tesoros y forma tripulaciones con otros jugadores.' 
WHERE JUEGO = 'Sea Of Thieves';

-- MiHoYo
UPDATE JUEGOS SET DESCRIPCION = 'Un RPG de mundo abierto de fantasía con un sistema de combate elemental. Explora el vasto mundo de Teyvat, colecciona personajes con diferentes elementos y habilidades.' 
WHERE JUEGO = 'Genshin Impact';

UPDATE JUEGOS SET DESCRIPCION = 'Un RPG de acción con mecánicas de gacha para móviles. Controla valkirias en combates de acción rápida contra enemigos del fin del mundo en un universo futurista.' 
WHERE JUEGO = 'Honkai Impact 3D';

UPDATE JUEGOS SET DESCRIPCION = 'Un RPG por turnos con una historia espacial épica. Recluta personajes, forma equipos y viaja por el cosmos en una aventura intergaláctica.' 
WHERE JUEGO = 'Honkai Star Rail';

UPDATE JUEGOS SET DESCRIPCION = 'Una novela visual y juego de romance con elementos de investigación legal. Interactúa con personajes, resuelve misterios y desarrolla relaciones en un mundo moderno.' 
WHERE JUEGO = 'Tears Of Themis';

UPDATE JUEGOS SET DESCRIPCION = 'Un RPG de acción urbana con estética anime. Juega como un agente especial en New Eridu, una metrópolis futurista, y combate contra amenazas sobrenaturales.' 
WHERE JUEGO = 'Zenless Zone Zero';

-- Mob Entertaiment
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de terror en primera persona donde exploras una fábrica de juguetes abandonada. Resuelve puzzles y escapa de Huggy Wuggy y otros juguetes terroríficos.' 
WHERE JUEGO = 'Poppy Playtime';

-- Mojang
UPDATE JUEGOS SET DESCRIPCION = 'El juego de bloques más popular de todos los tiempos. Construye, explora y sobrevive en un mundo generado proceduralmente lleno de aventuras y peligros.' 
WHERE JUEGO = 'Minecraft';

-- Ninja Wiki
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de estrategia tower defense donde colocas diferentes tipos de monos con habilidades únicas para defender tus territorios contra oleadas de globos.' 
WHERE JUEGO = 'Bloons TD 6';

-- Nintendo
UPDATE JUEGOS SET DESCRIPCION = 'Un simulador de vida donde te mudas a una isla desierta para crear tu comunidad ideal. Personaliza tu isla, interactúa con vecinos animales y disfruta al ritmo de las estaciones.' 
WHERE JUEGO = 'Animal Crossing New Horizons';

UPDATE JUEGOS SET DESCRIPCION = 'El juego de carreras de karts por excelencia. Compite con personajes de Nintendo en circuitos creativos, usa objetos para conseguir ventaja y disfruta de modos multijugador.' 
WHERE JUEGO = 'Mario Kart 8 Deluxe';

UPDATE JUEGOS SET DESCRIPCION = 'Un shooter en tercera persona por equipos donde controlas a Inklings que disparan tinta. Cubre el territorio con tu color en frenéticas batallas 4v4.' 
WHERE JUEGO = 'Splatoon';

UPDATE JUEGOS SET DESCRIPCION = 'Una aventura de plataformas 2D de Mario con nuevas mecánicas y poderes asombrosos. Juega solo o con amigos para superar niveles creativos y coloridos.' 
WHERE JUEGO = 'Super Mario Bros Wonder';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego que te permite crear, jugar y compartir tus propios niveles de Mario. Diseña desafíos únicos con diferentes estilos artísticos de la franquicia.' 
WHERE JUEGO = 'Super Mario Maker';

UPDATE JUEGOS SET DESCRIPCION = 'Una aventura en 3D donde Mario viaja por diversos reinos para rescatar a la Princesa Peach. Utiliza su nueva habilidad de posesión con Cappy para controlar objetos y enemigos.' 
WHERE JUEGO = 'Super Mario Odyssey';

-- Playrix
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de combinación de tres para móviles con elementos de pecera y decoración. Completa niveles combinando peces y personaliza tu acuario soñado.' 
WHERE JUEGO = 'Fishdom';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de combinación de tres para móviles con elementos de decoración de jardines. Ayuda a Austin a restaurar un hermoso jardín resolviendo puzzles combinados.' 
WHERE JUEGO = 'Gardenscapes';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de combinación de tres para móviles con elementos de decoración de interiores. Ayuda a Austin a renovar la mansión familiar resolviendo puzzles.' 
WHERE JUEGO = 'Homescapes';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de construcción de ciudades para móviles. Construye tu propia ciudad, administra granjas, fábricas y transportes mientras realizas misiones para expandir tu territorio.' 
WHERE JUEGO = 'Township';

-- Playstack
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de cartas roguelike con temática de póker. Construye manos poderosas, desbloquea jokers con efectos únicos y supera cada vez partidas más difíciles.' 
WHERE JUEGO = 'Balatro';

-- Psyonix
UPDATE JUEGOS SET DESCRIPCION = 'Un juego deportivo innovador que mezcla fútbol y vehículos acrobáticos. Controla un coche con turbo para golpear un balón gigante y marcar goles espectaculares.' 
WHERE JUEGO = 'Rocket League';

-- Re-Logic
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de aventuras y construcción en 2D. Explora, construye, combate y sobrevive en un mundo generado proceduralmente con jefes épicos y progresión de equipo.' 
WHERE JUEGO = 'Terraria';

-- Riot Games
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de cartas digital ambientado en el universo de League of Legends. Construye mazos con campeones y seguidores de las regiones de Runeterra.' 
WHERE JUEGO = 'Legends Of Runeterra';

UPDATE JUEGOS SET DESCRIPCION = 'Un MOBA donde dos equipos de cinco jugadores compiten por destruir la base enemiga. Selecciona entre más de 140 campeones con habilidades únicas.' 
WHERE JUEGO = 'League of Legends';

UPDATE JUEGOS SET DESCRIPCION = 'Un auto-battler basado en el universo de League of Legends. Recluta, posiciona y mejora unidades para crear sinergias poderosas y derrotar a otros jugadores.' 
WHERE JUEGO = 'Teamfight Tactics';

-- Roblox Corporation
UPDATE JUEGOS SET DESCRIPCION = 'Una plataforma de juego social donde los usuarios pueden crear y jugar millones de experiencias diferentes creadas por la comunidad. Un universo de juegos en constante expansión.' 
WHERE JUEGO = 'Roblox';

-- Scopely
UPDATE JUEGOS SET DESCRIPCION = 'Una versión para móviles del clásico juego de mesa. Compra propiedades, construye casas y hoteles, y arruina a tus amigos con alquileres exorbitantes en un formato casual y social.' 
WHERE JUEGO = 'Monopoly GO';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de carreras de obstáculos multijugador similar a Fall Guys. Compite contra otros jugadores en cursos desafiantes llenos de obstáculos y trampas.' 
WHERE JUEGO = 'Stumble Guys';

-- Sega
UPDATE JUEGOS SET DESCRIPCION = 'Una serie de RPG japoneses que mezcla la vida escolar con aventuras sobrenaturales. Forma vínculos sociales durante el día y explora calabozos llenos de sombras por la noche.' 
WHERE JUEGO = 'Persona';

UPDATE JUEGOS SET DESCRIPCION = 'La mascota más rápida de los videojuegos. Corre a velocidades supersónicas, recoge anillos y derrota al Dr. Eggman en coloridas aventuras de plataformas.' 
WHERE JUEGO = 'Sonic';

UPDATE JUEGOS SET DESCRIPCION = 'Una obra maestra de los juegos de acción y aventura con elementos de mundo abierto ambientada en Japón. Sigue la historia de Kiryu Kazuma y otros personajes del submundo criminal.' 
WHERE JUEGO = 'Yakuza';

-- SemiWork
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de simulación donde gestionas un sistema de repositorios. Organiza código, resuelve problemas de integración y lidia con las complejidades del desarrollo de software.' 
WHERE JUEGO = 'REPO';

-- Sid Meier
UPDATE JUEGOS SET DESCRIPCION = 'El juego original que inició la legendaria serie de estrategia por turnos. Lleva a tu civilización desde la Edad de Piedra hasta la Era Espacial.' 
WHERE JUEGO = 'Civilization I';

UPDATE JUEGOS SET DESCRIPCION = 'La séptima entrega de la aclamada serie de estrategia 4X. Construye un imperio, investiga tecnologías, establece relaciones diplomáticas y conquista el mundo a través de diferentes eras.' 
WHERE JUEGO = 'Civilization VII';

-- Smartly Dressed Games
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de supervivencia en mundo abierto con gráficos tipo voxel. Sobrevive al apocalipsis zombie, construye bases, busca recursos y enfrenta a otros jugadores.' 
WHERE JUEGO = 'Unturned';

-- Sony
UPDATE JUEGOS SET DESCRIPCION = 'Una épica saga de acción y aventura basada en la mitología nórdica. Controla a Kratos, el fantasma de Esparta, en su búsqueda de redención mientras protege a su hijo Atreus.' 
WHERE JUEGO = 'God Of War';

UPDATE JUEGOS SET DESCRIPCION = 'Un simulador de carreras realista exclusivo de PlayStation. Compite en circuitos de todo el mundo con cientos de vehículos meticulosamente recreados.' 
WHERE JUEGO = 'Gran Turismo';

UPDATE JUEGOS SET DESCRIPCION = 'Una serie de aventuras cinematográficas que sigue a Nathan Drake, un cazador de tesoros carismático que viaja por el mundo descubriendo reliquias antiguas y enfrentando peligros.' 
WHERE JUEGO = 'Uncharted';

-- StarBreeze
UPDATE JUEGOS SET DESCRIPCION = 'Un shooter cooperativo centrado en atracos. Forma un equipo de hasta cuatro jugadores para ejecutar robos elaborados mientras enfrentas a la policía y fuerzas especiales.' 
WHERE JUEGO = 'Payday';

-- Studio MDHR
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de plataformas y disparos inspirado en los dibujos animados de los años 30. Conocido por su dificultad y su impresionante animación dibujada a mano.' 
WHERE JUEGO = 'Cuphead';

-- Studio Wildcard
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de supervivencia en un mundo abierto lleno de dinosaurios. Domestica criaturas prehistóricas, construye bases, forma tribus y domina el hostil entorno.' 
WHERE JUEGO = 'Ark';

-- Supercell
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de estrategia móvil donde defiendes tu base contra invasiones enemigas. Construye defensas, entrena tropas y ataca otras bases en este juego de guerra naval.' 
WHERE JUEGO = 'Boom Beach';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de batallas en arena con personajes únicos. Participa en diferentes modos de juego 3v3, desbloquea y mejora brawlers con habilidades especiales.' 
WHERE JUEGO = 'Brawl Stars';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de estrategia móvil donde construyes tu aldea, entrenas tropas y atacas a otros jugadores. Forma un clan, participa en guerras y mejora tus defensas.' 
WHERE JUEGO = 'Clash Of Clans';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de cartas de estrategia en tiempo real. Construye mazos poderosos con cartas de diferentes rarezas y compite en intensas batallas 1v1 en arenas.' 
WHERE JUEGO = 'Clash Royale';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de simulación de granja para móviles. Cultiva cosechas, cría animales, personaliza tu granja y comercia con otros jugadores en un entorno rural tranquilo.' 
WHERE JUEGO = 'Hay Day';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego basado en mascotas virtuales donde entrenas y cuidas a una variedad de criaturas. Personaliza tu mascota, completa misiones y compite en torneos.' 
WHERE JUEGO = 'Mo.co';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de acción por equipos donde controlas escuadrones en intensas batallas. Recluta héroes, forma estrategias y domina el campo de batalla en este shooter táctico.' 
WHERE JUEGO = 'Squad Busters';

-- Team 17
UPDATE JUEGOS SET DESCRIPCION = 'Un metroidvania de acción con temática religiosa. Explora un mundo gótico, desata poderosos ataques y descubre una historia oscura inspirada en la religión española.' 
WHERE JUEGO = 'Blasphemous';

UPDATE JUEGOS SET DESCRIPCION = 'Un frenético juego de cocina cooperativo. Coordínate con amigos para preparar platos, servir clientes y superar cocinas cada vez más caóticas y desafiantes.' 
WHERE JUEGO = 'Overcooked';

-- Team Cherry
UPDATE JUEGOS SET DESCRIPCION = 'Un metroidvania aclamado por la crítica con un estilo artístico distintivo. Explora el reino subterráneo de Hallownest, desbloquea habilidades y descubre una historia melancólica.' 
WHERE JUEGO = 'Hollow Knight';

-- The India Stone
UPDATE JUEGOS SET DESCRIPCION = 'Un simulador de supervivencia en un apocalipsis zombie con énfasis en el realismo. Construye refugios, busca recursos, combate zombies y sobrevive en un mundo hostil.' 
WHERE JUEGO = 'Project Zomboid';

-- The Pokemon Company
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de simulación de cafetería con Pokémon. Prepara bebidas y platos para clientes Pokémon, decora tu café y expande tu negocio.' 
WHERE JUEGO = 'Pokemon Cafe';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de realidad aumentada para móviles donde capturas Pokémon en el mundo real. Explora tu entorno, participa en incursiones y compite en la Liga Pokémon.' 
WHERE JUEGO = 'Pokemon GO';

UPDATE JUEGOS SET DESCRIPCION = 'Una versión móvil del popular juego de cartas coleccionables. Construye mazos estratégicos, colecciona cartas raras y compite contra jugadores de todo el mundo.' 
WHERE JUEGO = 'Pokemon TCG Pocket';

UPDATE JUEGOS SET DESCRIPCION = 'El juego de cartas coleccionables original de Pokémon. Construye mazos con diferentes tipos de Pokémon, usa cartas de energía y estrategias para derrotar a tus oponentes.' 
WHERE JUEGO = 'Pokemon Trading Card Game';

-- Toby Fox
UPDATE JUEGOS SET DESCRIPCION = 'Un RPG único donde cada decisión importa y puedes resolver conflictos sin violencia. Conocido por su narrativa innovadora, personajes memorables y banda sonora excepcional.' 
WHERE JUEGO = 'Undertale';

-- Ubisoft
UPDATE JUEGOS SET DESCRIPCION = 'Una saga de acción y aventura histórica. Juega como un asesino que se mueve en las sombras a través de diferentes épocas, desde el Antiguo Egipto hasta la Revolución Industrial.' 
WHERE JUEGO = 'Assassins Creed';

UPDATE JUEGOS SET DESCRIPCION = 'Un shooter en primera persona de mundo abierto ambientado en una isla tropical. Enfrenta a un carismático villano mientras liberas territorios y causas caos con un arsenal diverso.' 
WHERE JUEGO = 'Far Cry 6';

UPDATE JUEGOS SET DESCRIPCION = 'Un shooter táctico 5v5 centrado en la destrucción de entornos y el trabajo en equipo. Selecciona entre diversos operadores con gadgets únicos para atacar o defender objetivos.' 
WHERE JUEGO = 'Rainbow Six Siege';

UPDATE JUEGOS SET DESCRIPCION = 'Un shooter looter de mundo abierto ambientado en Washington D.C. tras una pandemia. Juega solo o en equipo para restaurar el orden, mejorar tu equipamiento y enfrentar facciones enemigas.' 
WHERE JUEGO = 'The Division 2';

UPDATE JUEGOS SET DESCRIPCION = 'Un juego de carreras arcade con énfasis en la habilidad y la precisión. Compite en pistas creativas, bate récords y domina las mecánicas de conducción para convertirte en el mejor.' 
WHERE JUEGO = 'Trackmania';

UPDATE JUEGOS SET DESCRIPCION = 'Una aventura de acción en un Londres futurista donde puedes hackear y reclutar a cualquier NPC. Resiste contra un régimen opresivo con un equipo diverso de personajes aleatorios.' 
WHERE JUEGO = 'Watch Dogs Legion';

-- Valve
UPDATE JUEGOS SET DESCRIPCION = 'El shooter táctico competitivo por excelencia. Dos equipos se enfrentan en intensas rondas de eliminación donde la precisión, la estrategia y el trabajo en equipo son clave.' 
WHERE JUEGO = 'Counter Strike Global Offensive';

UPDATE JUEGOS SET DESCRIPCION = 'Un MOBA profundamente estratégico. Dos equipos de cinco jugadores se enfrentan por destruir el Ancient enemigo, con más de 100 héroes y un árbol de talentos complejo.' 
WHERE JUEGO = 'Dota 2';

UPDATE JUEGOS SET DESCRIPCION = 'Una revolucionaria serie de shooters en primera persona que mezcla acción y narrativa. Sigue las aventuras de Gordon Freeman en un mundo invadido por alienígenas.' 
WHERE JUEGO = 'Half Life';

UPDATE JUEGOS SET DESCRIPCION = 'Un shooter cooperativo de supervivencia zombie donde cuatro jugadores deben sobrevivir a hordas de infectados. Conocido por su sistema Director que adapta la dificultad dinámicamente.' 
WHERE JUEGO = 'Left 4 Dead';

UPDATE JUEGOS SET DESCRIPCION = 'Un innovador juego de puzzles en primera persona donde utilizas un arma de portales para resolver ingeniosos desafíos físicos. Conocido por su humor oscuro y su antagonista GLaDOS.' 
WHERE JUEGO = 'Portal';

UPDATE JUEGOS SET DESCRIPCION = 'Un shooter por clases en un universo caricaturesco. Dos equipos se enfrentan por objetivos con nueve clases distintas, cada una con roles específicos y estilos de juego únicos.' 
WHERE JUEGO = 'Team Fortress';

-- Wargaming
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de acción táctica de combate naval. Controla barcos históricos de diversas naciones, personaliza tus navíos y participa en batallas navales estratégicas por equipos.' 
WHERE JUEGO = 'World Of Warships';

-- Zeekerss
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de terror cooperativo donde un equipo de trabajadores recolecta chatarra en lunas peligrosas para cumplir con cuotas corporativas, enfrentando peligrosas criaturas.' 
WHERE JUEGO = 'Lethal Company';

-- Actualizar descripciones adicionales para juegos que puedan haberme faltado
UPDATE JUEGOS SET DESCRIPCION = 'Un juego de aventura y exploración espacial donde investigas un sistema solar atrapado en un bucle temporal. Resuelve misterios, descubre secretos cósmicos y desentraña la historia.' 
WHERE JUEGO = 'Outer Wilds' AND DESCRIPCION IS NULL;

UPDATE JUEGOS SET DESCRIPCION = 'Una serie de juegos de estrategia que abarcan diversas épocas históricas. Gestiona ejércitos, dirige campañas militares y domina el campo de batalla con precisión táctica.' 
WHERE JUEGO = 'Total War' AND DESCRIPCION IS NULL;

-- Asegurémonos de que ningún juego quede sin descripción
UPDATE JUEGOS SET DESCRIPCION = 'Un emocionante juego desarrollado por un estudio reconocido en la industria. Ofrece experiencias de juego únicas y entretenidas para jugadores de todos los niveles.' 
WHERE DESCRIPCION IS NULL;

-- Opcional: Actualiza algunas categorías adicionales que puedan faltar
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Card Game') 
WHERE JUEGO IN ('Pokemon Trading Card Game', 'Pokemon TCG Pocket') AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'MMORPG') 
WHERE JUEGO = 'World of Warcraft' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Metroidvania') 
WHERE JUEGO IN ('Hollow Knight', 'Blasphemous') AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Simulación') 
WHERE JUEGO IN ('Microsoft Flight Simulator', 'Hay Day', 'Animal Crossing New Horizons') AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Carreras') 
WHERE JUEGO IN ('F1 24', 'Gran Turismo', 'Trackmania', 'Mario Kart 8 Deluxe') AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Supervivencia') 
WHERE JUEGO IN ('Project Zomboid', 'Raft', 'DayZ', 'Ark') AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Tower Defense') 
WHERE JUEGO = 'Bloons TD 6' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Puzzle') 
WHERE JUEGO = 'Portal' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Hack and Slash') 
WHERE JUEGO = 'God Of War' AND ID_CATEGORIA IS NULL;

-- Asignar categorías a todos los juegos que aún no tienen categoría

-- Activison Blizzard
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'Call of Duty Black Ops 6' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Plataformas') 
WHERE JUEGO = 'Crash Bandicot 4' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'RPG') 
WHERE JUEGO = 'Diablo' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Card Game') 
WHERE JUEGO = 'Hearthstone' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'Overwatch' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'RTS') 
WHERE JUEGO = 'StarCraft 2' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'MMORPG') 
WHERE JUEGO = 'World of Warcraft' AND ID_CATEGORIA IS NULL;

-- Axolot Games
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Survival') 
WHERE JUEGO = 'Raft' AND ID_CATEGORIA IS NULL;

-- Bandai Namco
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'RPG') 
WHERE JUEGO = 'Dark Souls' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Fighting') 
WHERE JUEGO = 'Dragon Ball Z Budokai Tenkaichi' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Arcade') 
WHERE JUEGO = 'Pacman' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Fighting') 
WHERE JUEGO = 'Tekken' AND ID_CATEGORIA IS NULL;

-- Blobfish
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Roguelike') 
WHERE JUEGO = 'Brotato' AND ID_CATEGORIA IS NULL;

-- Bohemia Interactive
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'ARMA' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Survival') 
WHERE JUEGO = 'DayZ' AND ID_CATEGORIA IS NULL;

-- CD PROJEKT RED
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'RPG') 
WHERE JUEGO = 'Cyberpunk' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'RPG') 
WHERE JUEGO = 'The Witcher 3 Wild Hunt' AND ID_CATEGORIA IS NULL;

-- Chiliroom
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Roguelike') 
WHERE JUEGO = 'Soul Knight' AND ID_CATEGORIA IS NULL;

-- Devolver Digital
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Roguelike') 
WHERE JUEGO = 'Cult Of The Lamb' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Roguelike') 
WHERE JUEGO = 'Enter The Gungeon' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Acción') 
WHERE JUEGO = 'Hotline Miami' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Acción') 
WHERE JUEGO = 'My Friend Pedro' AND ID_CATEGORIA IS NULL;

-- EA
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Battle Royale') 
WHERE JUEGO = 'Apex Legends' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Aventura') 
WHERE JUEGO = 'A Way Out' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'Battlefield' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Carreras') 
WHERE JUEGO = 'F1 24' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Deportes') 
WHERE JUEGO = 'FIFA' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Aventura') 
WHERE JUEGO = 'It Takes Two' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Simulación') 
WHERE JUEGO = 'Los Sims' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'RPG') 
WHERE JUEGO = 'Mass Effect' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Tower Defense') 
WHERE JUEGO = 'Plants Vs Zombies' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Simulación') 
WHERE JUEGO = 'SimCity' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Simulación') 
WHERE JUEGO = 'Spore' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'Star Wars Battlefront' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'Titanfall' AND ID_CATEGORIA IS NULL;

-- Epic Games
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Battle Royale') 
WHERE JUEGO = 'Fortnite' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'Gears Of War' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'RPG') 
WHERE JUEGO = 'Infinity Blade' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'Unreal Tournament' AND ID_CATEGORIA IS NULL;

-- Grinding Gear Games
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'RPG') 
WHERE JUEGO = 'Path Of Exile' AND ID_CATEGORIA IS NULL;

-- Habby
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Roguelike') 
WHERE JUEGO = 'Archero 2' AND ID_CATEGORIA IS NULL;

-- Hi-Rez
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'Paladins' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'MOBA') 
WHERE JUEGO = 'Smite' AND ID_CATEGORIA IS NULL;

-- Innersloth
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Indie') 
WHERE JUEGO = 'Among Us' AND ID_CATEGORIA IS NULL;

-- Kinetic Games
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Survival Horror') 
WHERE JUEGO = 'Phasmophobia' AND ID_CATEGORIA IS NULL;

-- Maddy Makes Games
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Plataformas') 
WHERE JUEGO = 'Celeste' AND ID_CATEGORIA IS NULL;

-- Marvel
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'Marvel Rivals' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Card Game') 
WHERE JUEGO = 'Marvel Snap' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Acción') 
WHERE JUEGO = 'Marvel Spiderman Miles Morales' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'RPG') 
WHERE JUEGO = 'Marvel Strike Force' AND ID_CATEGORIA IS NULL;

-- MediaTonic
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Battle Royale') 
WHERE JUEGO = 'Fall Guys' AND ID_CATEGORIA IS NULL;

-- Microsoft
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'RTS') 
WHERE JUEGO = 'Age Of Empires' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Carreras') 
WHERE JUEGO = 'Forza Horizon' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'Halo' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Simulación') 
WHERE JUEGO = 'Microsoft Flight Simulator' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Mundo abierto') 
WHERE JUEGO = 'Sea Of Thieves' AND ID_CATEGORIA IS NULL;

-- MiHoYo
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'MMORPG') 
WHERE JUEGO = 'Genshin Impact' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'RPG') 
WHERE JUEGO = 'Honkai Impact 3D' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Turnos') 
WHERE JUEGO = 'Honkai Star Rail' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Visual Novel') 
WHERE JUEGO = 'Tears Of Themis' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'RPG') 
WHERE JUEGO = 'Zenless Zone Zero' AND ID_CATEGORIA IS NULL;

-- Mob Entertaiment
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Survival Horror') 
WHERE JUEGO = 'Poppy Playtime' AND ID_CATEGORIA IS NULL;

-- Mobius Digital
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Aventura') 
WHERE JUEGO = 'Outer Wilds' AND ID_CATEGORIA IS NULL;

-- Mojang
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Sandbox') 
WHERE JUEGO = 'Minecraft' AND ID_CATEGORIA IS NULL;

-- Ninja Wiki
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Tower Defense') 
WHERE JUEGO = 'Bloons TD 6' AND ID_CATEGORIA IS NULL;

-- Nintendo
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Simulación') 
WHERE JUEGO = 'Animal Crossing New Horizons' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Carreras') 
WHERE JUEGO = 'Mario Kart 8 Deluxe' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'Splatoon' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Plataformas') 
WHERE JUEGO = 'Super Mario Bros Wonder' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Plataformas') 
WHERE JUEGO = 'Super Mario Maker' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Plataformas') 
WHERE JUEGO = 'Super Mario Odyssey' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Mundo abierto') 
WHERE JUEGO = 'Zelda Breath Of The Wild' AND ID_CATEGORIA IS NULL;

-- Playrix
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Puzzle') 
WHERE JUEGO = 'Fishdom' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Puzzle') 
WHERE JUEGO = 'Gardenscapes' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Puzzle') 
WHERE JUEGO = 'Homescapes' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Simulación') 
WHERE JUEGO = 'Township' AND ID_CATEGORIA IS NULL;

-- Playstack
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Card Game') 
WHERE JUEGO = 'Balatro' AND ID_CATEGORIA IS NULL;

-- Psyonix
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Deportes') 
WHERE JUEGO = 'Rocket League' AND ID_CATEGORIA IS NULL;

-- Re-Logic
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Sandbox') 
WHERE JUEGO = 'Terraria' AND ID_CATEGORIA IS NULL;

-- Riot Games
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Card Game') 
WHERE JUEGO = 'Legends Of Runeterra' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'MOBA') 
WHERE JUEGO = 'League of Legends' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Estrategia') 
WHERE JUEGO = 'Teamfight Tactics' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'Valorant' AND ID_CATEGORIA IS NULL;

-- Roblox Corporation
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Sandbox') 
WHERE JUEGO = 'Roblox' AND ID_CATEGORIA IS NULL;

-- Rockstar Games
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Mundo abierto') 
WHERE JUEGO = 'Grand Theft Auto V' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Mundo abierto') 
WHERE JUEGO = 'Red Dead Redemption 2' AND ID_CATEGORIA IS NULL;

-- Scopely
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Gestión') 
WHERE JUEGO = 'Monopoly GO' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Battle Royale') 
WHERE JUEGO = 'Stumble Guys' AND ID_CATEGORIA IS NULL;

-- Sega
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'RPG') 
WHERE JUEGO = 'Persona' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Plataformas') 
WHERE JUEGO = 'Sonic' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Estrategia') 
WHERE JUEGO = 'Total War' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'RPG') 
WHERE JUEGO = 'Yakuza' AND ID_CATEGORIA IS NULL;

-- SemiWork
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Simulación') 
WHERE JUEGO = 'REPO' AND ID_CATEGORIA IS NULL;

-- Sid Meier
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Estrategia') 
WHERE JUEGO = 'Civilization I' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Estrategia') 
WHERE JUEGO = 'Civilization VII' AND ID_CATEGORIA IS NULL;

-- Smartly Dressed Games
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Survival') 
WHERE JUEGO = 'Unturned' AND ID_CATEGORIA IS NULL;

-- Sony
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Hack and Slash') 
WHERE JUEGO = 'God Of War' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Carreras') 
WHERE JUEGO = 'Gran Turismo' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Aventura') 
WHERE JUEGO = 'The Last Of Us' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Aventura') 
WHERE JUEGO = 'Uncharted' AND ID_CATEGORIA IS NULL;

-- StarBreeze
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'Payday' AND ID_CATEGORIA IS NULL;

-- Studio MDHR
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Plataformas') 
WHERE JUEGO = 'Cuphead' AND ID_CATEGORIA IS NULL;

-- Studio Wildcard
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Survival') 
WHERE JUEGO = 'Ark' AND ID_CATEGORIA IS NULL;

-- Supercell
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Estrategia') 
WHERE JUEGO = 'Boom Beach' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'MOBA') 
WHERE JUEGO = 'Brawl Stars' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Estrategia') 
WHERE JUEGO = 'Clash Of Clans' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Estrategia') 
WHERE JUEGO = 'Clash Royale' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Simulación') 
WHERE JUEGO = 'Hay Day' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Simulación') 
WHERE JUEGO = 'Mo.co' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Acción') 
WHERE JUEGO = 'Squad Busters' AND ID_CATEGORIA IS NULL;

-- Team 17
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Metroidvania') 
WHERE JUEGO = 'Blasphemous' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Simulación') 
WHERE JUEGO = 'Overcooked' AND ID_CATEGORIA IS NULL;

-- Team Cherry
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Metroidvania') 
WHERE JUEGO = 'Hollow Knight' AND ID_CATEGORIA IS NULL;

-- The India Stone
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Survival') 
WHERE JUEGO = 'Project Zomboid' AND ID_CATEGORIA IS NULL;

-- The Pokemon Company
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Simulación') 
WHERE JUEGO = 'Pokemon Cafe' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Realidad Aumentada') 
WHERE JUEGO = 'Pokemon GO' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Card Game') 
WHERE JUEGO = 'Pokemon TCG Pocket' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Card Game') 
WHERE JUEGO = 'Pokemon Trading Card Game' AND ID_CATEGORIA IS NULL;

-- Toby Fox
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'RPG') 
WHERE JUEGO = 'Undertale' AND ID_CATEGORIA IS NULL;

-- Ubisoft
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Acción') 
WHERE JUEGO = 'Assassins Creed' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'Far Cry 6' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'Rainbow Six Siege' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'The Division 2' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Carreras') 
WHERE JUEGO = 'Trackmania' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Acción') 
WHERE JUEGO = 'Watch Dogs Legion' AND ID_CATEGORIA IS NULL;

-- Valve
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'Counter Strike Global Offensive' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'MOBA') 
WHERE JUEGO = 'Dota 2' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'Half Life' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'Left 4 Dead' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Puzzle') 
WHERE JUEGO = 'Portal' AND ID_CATEGORIA IS NULL;

UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Shooter') 
WHERE JUEGO = 'Team Fortress' AND ID_CATEGORIA IS NULL;

-- Wargaming
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Simulación') 
WHERE JUEGO = 'World Of Warships' AND ID_CATEGORIA IS NULL;

-- Zeekerss
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Survival Horror') 
WHERE JUEGO = 'Lethal Company' AND ID_CATEGORIA IS NULL;

-- Verificar que todos los juegos tienen ahora una categoría asignada
-- Si aún quedan juegos sin categoría, les asignamos una genérica (Acción)
UPDATE JUEGOS SET ID_CATEGORIA = (SELECT ID_CATEGORIA FROM CATEGORIAS WHERE CATEGORIA = 'Acción') 
WHERE ID_CATEGORIA IS NULL;