"""Estudo de strings utilizando url"""
url = "http://bytebank.com/cambio?quantidade=100&moedaOrigem=real&moedaDestino=dolar"

# Sanitização da url
url = url.strip()

# Validação da url
if url == '':
    raise ValueError("A URL está vazia")

# Separa base e os parâmetros
indice_interrogacao = url.find("?")
url_base = url[:indice_interrogacao]
url_parametros = url[indice_interrogacao+1:]
print(url_parametros)

# Busca o valor de um parâmetro
parametro_busca = 'moedaDestino'
indice_parametro = url_parametros.find(parametro_busca)
indice_valor = indice_parametro + len(parametro_busca) + 1
indice_e_comercial = url_parametros.find('&', indice_valor)
if indice_e_comercial == -1:
    valor = url_parametros[indice_valor:]
else:
    valor = url_parametros[indice_valor:indice_e_comercial]
print(valor)
