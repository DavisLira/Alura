"""Classe Extrator URL"""
import re

class ExtratorURL:
    """Classe utilizada para Extrair algo da URL"""

    def __init__(self, url):
        self.url = self.sanitiza_url(url)
        self.valida_url()

    def sanitiza_url(self, url):
        """Limpa a url, tirando os espaços em branco"""
        if isinstance(url, str):
            return url.strip()
        return ""

    def valida_url(self):
        """Verifica se a URL está vazia"""
        if not self.url:
            raise ValueError("A URL está vazia")

        padrao_url = re.compile('(http(s)?://)?(www.)?bytebank.com(.br)?/cambio')
        match = padrao_url.match(self.url)
        if not match:
            raise ValueError("A URL não é válida")

    def get_url_base(self):
        """Retorna a URL base"""
        indice_interrogacao = self.url.find("?")
        url_base = self.url[:indice_interrogacao]
        return url_base

    def get_url_parametros(self):
        """Retorna os parâmetros da URL"""
        indice_interrogacao = self.url.find("?")
        url_parametros = self.url[indice_interrogacao+1:]
        return url_parametros

    def get_valor_parametro(self, parametro_busca):
        """Busca o valor de um parâmetro"""
        indice_parametro = self.get_url_parametros().find(parametro_busca)
        indice_valor = indice_parametro + len(parametro_busca) + 1
        indice_e_comercial = self.get_url_parametros().find('&', indice_valor)
        if indice_e_comercial == -1:
            valor = self.get_url_parametros()[indice_valor:]
            return valor
        valor = self.get_url_parametros()[indice_valor:indice_e_comercial]
        return valor

    def __len__(self):
        return len(self.url)

    def __str__(self):
        return self.url + "\n" + "Parâmetros: " + self.get_url_parametros() + \
                            "\n" + "Url Base: " + self.get_url_base()

    def __eq__(self, other):
        return self.url == other.url

extrator_url = ExtratorURL("bytebank.com/cambio?quantidade=315.20&\
moedaOrigem=real&moedaDestino=dolar")

VALOR_DOLAR = 5.50
moeda_origem = extrator_url.get_valor_parametro("moedaOrigem")
moeda_destino = extrator_url.get_valor_parametro("moedaDestino")
quantidade = extrator_url.get_valor_parametro("quantidade")

print(moeda_origem)
print(moeda_destino)
print(quantidade)

if moeda_origem == "real" and moeda_destino == "dolar":
    valor_conversao = round(float(quantidade) / VALOR_DOLAR, 2)
    print(f"O valor de R${quantidade} é igual a ${valor_conversao}")
elif moeda_origem == "dolar" and moeda_destino == "real":
    valor_conversao = round(float(quantidade) * VALOR_DOLAR, 2)
    print(f"O valor de ${quantidade} é igual a R${valor_conversao}")
else:
    print(f"Câmbio de {moeda_origem} para {moeda_destino} não está disponível.")



# extrator_url_2 = ExtratorURL("http://bytebank.com/cambio?quantidade=100&\
# moedaOrigem=real&moedaDestino=dolar")

# tamanho_url = len(extrator_url)
# print(f"O tamanho da URL é: {tamanho_url}")
# print(extrator_url)
# print(extrator_url == extrator_url_2)

# extrator_url = ExtratorURL(None)
# valor_quantidade = extrator_url.get_valor_parametro('quantidade')
# print(valor_quantidade)
