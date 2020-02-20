#classic where : pas moyen de savoir quel condition matche

select id, sub_title_fr, first_name 

from artiste 


where 

( sub_title_fr like "alain%" or sub_title_fr like "artiste%" or sub_title_fr like "ballet%" )
or ( first_name like "alain%" or first_name like "artiste%" or first_name like "ballet%" )






#left join par colone : permet de savoir si au moins un match par colone.

select artiste.id, artiste.sub_title_fr, artiste.first_name , artiste_subtitle.id, artiste_firstname.id

from artiste 
left join artiste as artiste_subtitle ON ( artiste.sub_title_fr like "alain%" or artiste.sub_title_fr like "artiste%" or artiste.sub_title_fr like "ballet%" ) and artiste_subtitle.id = artiste.id
left join artiste as artiste_firstname ON ( artiste.first_name like "alain%" or artiste.first_name like "artiste%" or artiste.first_name like "ballet%" ) and artiste_firstname.id = artiste.id

where 
artiste_subtitle.id is not null or artiste_firstname.id is not null




#left join par colone+mot : permet de savoir chaque mot pour chaque colonne

select artiste.id, artiste.sub_title_fr, artiste.first_name , 
artiste_subtitle_1.id as subtitle_alain,
artiste_subtitle_2.id as subtitle_artiste,
artiste_subtitle_3.id as subtitle_ballet,
artiste_firstname_1.id as firstname_alain,
artiste_firstname_2.id as firstname_artiste,
artiste_firstname_3.id as firstname_ballet

from artiste 
left join artiste as artiste_subtitle_1 ON ( artiste.sub_title_fr like LOWER("%alain%") ) and artiste_subtitle_1.id = artiste.id
left join artiste as artiste_subtitle_2 ON ( artiste.sub_title_fr like LOWER("%artiste%")  ) and artiste_subtitle_2.id = artiste.id
left join artiste as artiste_subtitle_3 ON ( artiste.sub_title_fr like LOWER("%ballet%")  ) and artiste_subtitle_3.id = artiste.id


left join artiste as artiste_firstname_1 ON ( artiste.first_name like LOWER("%alain%")) and artiste_firstname_1.id = artiste.id
left join artiste as artiste_firstname_2 ON ( artiste.first_name like LOWER("%artiste%" )) and artiste_firstname_2.id = artiste.id
left join artiste as artiste_firstname_3 ON ( artiste.first_name like LOWER("%ballet%" )) and artiste_firstname_3.id = artiste.id

where 

artiste_subtitle_1.id is not null 
or artiste_subtitle_2.id is not null
or artiste_subtitle_3.id is not null 

or artiste_firstname_1.id is not null
or artiste_firstname_2.id is not null
or artiste_firstname_3.id is not null


#tentative de classement du meilleur resultat: yes

select artiste.id, artiste.sub_title_fr, artiste.first_name , 
count(artiste_subtitle_1.id) as subtitle_alain,
count(artiste_subtitle_2.id) as subtitle_artiste,
count(artiste_subtitle_3.id) as subtitle_ballet,
count(artiste_firstname_1.id) as firstname_alain,
count(artiste_firstname_2.id) as firstname_artiste,
count(artiste_firstname_3.id) as firstname_ballet,

(
count(artiste_subtitle_1.id)  + 
count(artiste_subtitle_2.id)  + 
count(artiste_subtitle_3.id)  + 
count(artiste_firstname_1.id)  + 
count(artiste_firstname_2.id)  + 
count(artiste_firstname_3.id) ) as match_score

from artiste 
left join artiste as artiste_subtitle_1 ON ( artiste.sub_title_fr like LOWER("%alain%") ) and artiste_subtitle_1.id = artiste.id
left join artiste as artiste_subtitle_2 ON ( artiste.sub_title_fr like LOWER("%artiste%")  ) and artiste_subtitle_2.id = artiste.id
left join artiste as artiste_subtitle_3 ON ( artiste.sub_title_fr like LOWER("%ballet%")  ) and artiste_subtitle_3.id = artiste.id


left join artiste as artiste_firstname_1 ON ( artiste.first_name like LOWER("%alain%")) and artiste_firstname_1.id = artiste.id
left join artiste as artiste_firstname_2 ON ( artiste.first_name like LOWER("%artiste%" )) and artiste_firstname_2.id = artiste.id
left join artiste as artiste_firstname_3 ON ( artiste.first_name like LOWER("%ballet%" )) and artiste_firstname_3.id = artiste.id

where 

artiste_subtitle_1.id is not null 
or artiste_subtitle_2.id is not null
or artiste_subtitle_3.id is not null 

or artiste_firstname_1.id is not null
or artiste_firstname_2.id is not null
or artiste_firstname_3.id is not null

group by artiste.id
order by match_score DESC


#optimisation si index :)
explain
select artiste.id, artiste.sub_title_fr, artiste.first_name , 
count(artiste_subtitle_1.id) as subtitle_alain,
count(artiste_subtitle_2.id) as subtitle_artiste,
count(artiste_subtitle_3.id) as subtitle_ballet,
count(artiste_firstname_1.id) as firstname_alain,
count(artiste_firstname_2.id) as firstname_artiste,
count(artiste_firstname_3.id) as firstname_ballet,

(
count(artiste_subtitle_1.id)  + 
count(artiste_subtitle_2.id)  + 
count(artiste_subtitle_3.id)  + 
count(artiste_firstname_1.id)  + 
count(artiste_firstname_2.id)  + 
count(artiste_firstname_3.id) ) as match_score

from artiste 
left outer join artiste as artiste_subtitle_1 ON ( artiste.sub_title_fr like LOWER("alain%") ) and artiste_subtitle_1.id = artiste.id
left outer join artiste as artiste_subtitle_2 ON ( artiste.sub_title_fr like LOWER("artiste%")  ) and artiste_subtitle_2.id = artiste.id
left outer join artiste as artiste_subtitle_3 ON ( artiste.sub_title_fr like LOWER("ballet%")  ) and artiste_subtitle_3.id = artiste.id


left outer join artiste as artiste_firstname_1 ON ( artiste.first_name like LOWER("alain%")) and artiste_firstname_1.id = artiste.id
left outer join artiste as artiste_firstname_2 ON ( artiste.first_name like LOWER("artiste%" )) and artiste_firstname_2.id = artiste.id
left outer join artiste as artiste_firstname_3 ON ( artiste.first_name like LOWER("ballet%" )) and artiste_firstname_3.id = artiste.id

where 

( artiste.sub_title_fr like "alain%" or artiste.sub_title_fr like "artiste%" or artiste.sub_title_fr like "ballet%" )
or ( artiste.first_name like "alain%" or artiste.first_name like "artiste%" or artiste.first_name like "ballet%" )


and 
 (
artiste_subtitle_1.id is not null 
or artiste_subtitle_2.id is not null
or artiste_subtitle_3.id is not null 

or artiste_firstname_1.id is not null
or artiste_firstname_2.id is not null
or artiste_firstname_3.id is not null
)
group by artiste.id
order by match_score DESC
