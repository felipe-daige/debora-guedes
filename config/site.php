<?php

return [
    'admin' => [
        'name' => env('ADMIN_NAME', 'Administradora'),
        'email' => env('ADMIN_EMAIL', 'admin@example.com'),
        'password' => env('ADMIN_PASSWORD', 'change-me-now'),
    ],
    'name' => env('SITE_NAME', 'DG Imóveis Investimentos'),
    'signature' => env('SITE_SIGNATURE', 'Débora Guedes | CRECI 76771-F'),
    'creci' => env('SITE_CRECI', '76771-F'),
    'positioning' => 'Imóveis • Terrenos • Investimentos imobiliários',
    'subtitle' => 'Imóveis · Terrenos · Investimentos imobiliários',
    'location' => env('SITE_LOCATION', 'Itapema / Meia Praia — SC'),
    'phone' => env('SITE_PHONE', '(47) 99128-4765'),
    'whatsapp' => env('SITE_WHATSAPP', '5547991284765'),
    'email' => env('SITE_EMAIL', 'contato@dgimoveisinvestimentos.com.br'),
    'instagram' => env('SITE_INSTAGRAM', 'deboraguedesimoveis'),
    'properties' => [
        ['slug' => 'casa-jardim-europa', 'category' => 'Imóveis', 'status' => 'Venda', 'location' => 'Jardim Europa', 'type' => 'Casa', 'title' => 'Casa contemporânea com pé-direito duplo', 'description' => 'Projeto assinado, integração total com o jardim e piscina aquecida.', 'price' => 'R$ 2.890.000', 'area' => '380 m²', 'rooms' => 4, 'suites' => 3, 'parking' => 4, 'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1600&q=85'],
        ['slug' => 'apto-cobertura-vista-mar', 'category' => 'Imóveis', 'status' => 'Venda', 'location' => 'Beira Mar', 'type' => 'Cobertura', 'title' => 'Cobertura duplex com vista panorâmica', 'description' => 'Vista 270° do mar, piscina privativa e acabamentos de altíssimo padrão.', 'price' => 'R$ 4.250.000', 'area' => '295 m²', 'rooms' => 3, 'suites' => 3, 'parking' => 3, 'image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=1600&q=85'],
        ['slug' => 'casa-condominio-alphaville', 'category' => 'Imóveis', 'status' => 'Venda', 'location' => 'Alphaville Residencial', 'type' => 'Casa em condomínio', 'title' => 'Casa térrea em condomínio fechado', 'description' => 'Projeto familiar com jardim arborizado e espaço gourmet integrado.', 'price' => 'R$ 1.750.000', 'area' => '210 m²', 'rooms' => 3, 'suites' => 2, 'parking' => 2, 'image' => 'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?auto=format&fit=crop&w=1600&q=85'],
        ['slug' => 'apartamento-higienopolis', 'category' => 'Imóveis', 'status' => 'Venda', 'location' => 'Higienópolis', 'type' => 'Apartamento', 'title' => 'Apartamento reformado de frente para o parque', 'description' => 'Sala com varanda gourmet, vista verde e prédio com lazer.', 'price' => 'R$ 890.000', 'area' => '86 m²', 'rooms' => 2, 'suites' => 1, 'parking' => 1, 'image' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1600&q=85'],
        ['slug' => 'terreno-condominio-fechado', 'category' => 'Terrenos', 'status' => 'Venda', 'location' => 'Reserva das Palmeiras', 'type' => 'Terreno residencial', 'title' => 'Terreno plano em condomínio de alto padrão', 'description' => 'Lote plano, frente leste, em condomínio fechado com infraestrutura completa.', 'price' => 'R$ 680.000', 'area' => '720 m²', 'image' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=1600&q=85'],
        ['slug' => 'terreno-comercial-esquina', 'category' => 'Terrenos', 'status' => 'Venda', 'location' => 'Centro Comercial', 'type' => 'Terreno comercial', 'title' => 'Terreno de esquina em avenida comercial', 'description' => 'Esquina com alto fluxo, zoneamento comercial e excelente visibilidade.', 'price' => 'R$ 1.450.000', 'area' => '950 m²', 'zoning' => 'ZC — Zona Comercial', 'image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1600&q=85'],
        ['slug' => 'area-rural-nascente', 'category' => 'Terrenos', 'status' => 'Venda', 'location' => 'Zona Rural', 'type' => 'Área rural', 'title' => 'Área rural com 5 hectares e nascente', 'description' => 'Topografia favorável, nascente própria e acesso por estrada asfaltada.', 'price' => 'R$ 1.100.000', 'area' => '5 hectares', 'image' => 'https://images.unsplash.com/photo-1500076656116-558758c991c1?auto=format&fit=crop&w=1600&q=85'],
        ['slug' => 'area-incorporacao-zona-sul', 'category' => 'Áreas para incorporação', 'status' => 'Estudo de viabilidade', 'location' => 'Zona Sul de expansão', 'type' => 'Gleba urbana', 'title' => 'Gleba urbana com potencial construtivo elevado', 'description' => 'Gleba de 8.400 m² em zona de expansão, ideal para empreendimento vertical.', 'price' => 'Valor sob consulta', 'area' => '8.400 m²', 'zoning' => 'ZR-3 — permite até 12 pavimentos', 'image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1600&q=85'],
        ['slug' => 'area-loteamento-vetor-norte', 'category' => 'Áreas para incorporação', 'status' => 'Estudo de viabilidade', 'location' => 'Vetor de crescimento Norte', 'type' => 'Área para loteamento', 'title' => 'Área para loteamento residencial — 32.000 m²', 'description' => 'Vetor de expansão urbana, ideal para loteamento aberto ou fechado.', 'price' => 'Valor sob consulta', 'area' => '32.000 m²', 'zoning' => 'ZR-2 — uso residencial', 'image' => 'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?auto=format&fit=crop&w=1600&q=85'],
    ]];
