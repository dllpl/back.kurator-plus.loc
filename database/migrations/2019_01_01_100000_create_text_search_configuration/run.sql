create text search dictionary public.english_ispell (
    template = ispell,
    DictFile = english,
    AffFile = english,
    StopWords = english
);

create text search configuration public.english (
    copy = pg_catalog.english
);

alter text search configuration public.english
    alter mapping for asciiword, asciihword with public.english_ispell, english_stem;

create text search dictionary public.russian_ispell (
    template = ispell,
    DictFile = russian,
    AffFile = russian,
    StopWords = russian
);

create text search configuration public.russian (
    copy = pg_catalog.russian
);

alter text search configuration public.russian
    alter mapping for asciiword, asciihword with public.english_ispell, english_stem;

alter text search configuration public.russian
    alter mapping for word, hword, hword_part with public.russian_ispell, russian_stem;
