# Logger exercise

`composer install`

console command 

`php bin/console app:pro-logger teststring  1`

where "teststring" is just a string 
where "1" is Level ( 1 Debug, 2 Info, 3 Warning, 4 Error)

console command alternative
`php bin/console app:pro-logger teststring  1 prolib`

where "prolib" can be e-mail, file system, server APIs, etc...

for some some very heavy usage depending on which team uses it
there is ETC constant (Estimate to complete), which is set by default 0.2 seconds




