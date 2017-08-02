<?php
/* Template Name: Produtos - Decoratum */
/* https://getbootstrap.com/examples/grid/ */
get_header();
?>

<section class="product-cake sec-produtos">
    <div class="container">
        <div class="row mt-20 mb-20">
            <div class="col-md-3">
                <div class="dv-titulo-coluna mb-20">CATEGORIAS</div>
                <ul id="categoria-produtos">
                    <li>
                        <strong>Categoria 1</strong>
                        <ul>
                            <li>Item 1</li>
                            <li>
                                Item 2
                                <ul>
                                    <li>Item 3</li>
                                    <li>Item 4</li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <strong>Categoria 2</strong>
                        <ul>
                            <li>Item 5</li>
                            <li>Item 6</li>
                            <li>Item 7</li>
                        </ul>
                    </li>
                    <li>
                        <strong>Categoria 3</strong>
                        <ul>
                            <li>Item 8</li>
                            <li>Item 9</li>
                            <li>Item 10</li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="dv-titulo-coluna mb-20">
                    125 PRODUTOS

                    <ul id="filtros-produtos">
                        <li>
                            Ordenar por: <select id="ordenar-por"><option>Maior Preço</option><option>Menor Preço</option></select>
                        </li>
                        <li>1 | 2 | 3 | 4 | 5</li>
                    </ul>
                </div>

                <div class="row" id="lista-produtos">
                    <div class="col-md-4 mb-25 item-produto">
                        <img src="<?php bloginfo('template_url'); ?>/images/produtos-image-1.jpg" />
                        <div class="info-produto mt-15">
                            <div class="nome">Teste de Nome Um Pouco Maior Sim</div>
                            <div class="preco">
                                <span class="preco-de">R$10,00</span>
                                <br />
                                <span class="preco-por">R$9,99</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-25 item-produto">
                        <img src="<?php bloginfo('template_url'); ?>/images/produtos-image-2.jpg" />
                        <div class="info-produto mt-15">
                            <div class="nome">Teste de Nome Um Pouco Maior Sim</div>
                            <div class="preco">
                                <span class="preco-de">R$10,00</span>
                                <br />
                                <span class="preco-por">R$9,99</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-25 item-produto">
                        <img src="<?php bloginfo('template_url'); ?>/images/produtos-image-3.jpg" />
                        <div class="info-produto mt-15">
                            <div class="nome">Teste de Nome Um Pouco Maior Sim</div>
                            <div class="preco">
                                <span class="preco-de">R$10,00</span>
                                <br />
                                <span class="preco-por">R$9,99</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-25 item-produto">
                        <img src="<?php bloginfo('template_url'); ?>/images/produtos-image-2.jpg" />
                        <div class="info-produto mt-15">
                            <div class="nome">Teste de Nome Um Pouco Maior Sim</div>
                            <div class="preco">
                                <span class="preco-de">R$10,00</span>
                                <br />
                                <span class="preco-por">R$9,99</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-25 item-produto">
                        <img src="<?php bloginfo('template_url'); ?>/images/produtos-image-3.jpg" />
                        <div class="info-produto mt-15">
                            <div class="nome">Teste de Nome Um Pouco Maior Sim</div>
                            <div class="preco">
                                <span class="preco-de">R$10,00</span>
                                <br />
                                <span class="preco-por">R$9,99</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-25 item-produto">
                        <img src="<?php bloginfo('template_url'); ?>/images/produtos-image-1.jpg" />
                        <div class="info-produto mt-15">
                            <div class="nome">Teste de Nome Um Pouco Maior Sim</div>
                            <div class="preco">
                                <span class="preco-de">R$10,00</span>
                                <br />
                                <span class="preco-por">R$9,99</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-25 item-produto">
                        <img src="<?php bloginfo('template_url'); ?>/images/produtos-image-1.jpg" />
                        <div class="info-produto mt-15">
                            <div class="nome">Teste de Nome Um Pouco Maior Sim</div>
                            <div class="preco">
                                <span class="preco-de">R$10,00</span>
                                <br />
                                <span class="preco-por">R$9,99</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-25 item-produto">
                        <img src="<?php bloginfo('template_url'); ?>/images/produtos-image-2.jpg" />
                        <div class="info-produto mt-15">
                            <div class="nome">Teste de Nome Um Pouco Maior Sim</div>
                            <div class="preco">
                                <span class="preco-de">R$10,00</span>
                                <br />
                                <span class="preco-por">R$9,99</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-25 item-produto">
                        <img src="<?php bloginfo('template_url'); ?>/images/produtos-image-3.jpg" />
                        <div class="info-produto mt-15">
                            <div class="nome">Teste de Nome Um Pouco Maior Sim</div>
                            <div class="preco">
                                <span class="preco-de">R$10,00</span>
                                <br />
                                <span class="preco-por">R$9,99</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-25 item-produto">
                        <img src="<?php bloginfo('template_url'); ?>/images/produtos-image-2.jpg" />
                        <div class="info-produto mt-15">
                            <div class="nome">Teste de Nome Um Pouco Maior Sim</div>
                            <div class="preco">
                                <span class="preco-de">R$10,00</span>
                                <br />
                                <span class="preco-por">R$9,99</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-25 item-produto">
                        <img src="<?php bloginfo('template_url'); ?>/images/produtos-image-3.jpg" />
                        <div class="info-produto mt-15">
                            <div class="nome">Teste de Nome Um Pouco Maior Sim</div>
                            <div class="preco">
                                <span class="preco-de">R$10,00</span>
                                <br />
                                <span class="preco-por">R$9,99</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-25 item-produto">
                        <img src="<?php bloginfo('template_url'); ?>/images/produtos-image-1.jpg" />
                        <div class="info-produto mt-15">
                            <div class="nome">Teste de Nome Um Pouco Maior Sim</div>
                            <div class="preco">
                                <span class="preco-de">R$10,00</span>
                                <br />
                                <span class="preco-por">R$9,99</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-25 item-produto">
                        <img src="<?php bloginfo('template_url'); ?>/images/produtos-image-1.jpg" />
                        <div class="info-produto mt-15">
                            <div class="nome">Teste de Nome Um Pouco Maior Sim</div>
                            <div class="preco">
                                <span class="preco-de">R$10,00</span>
                                <br />
                                <span class="preco-por">R$9,99</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-25 item-produto">
                        <img src="<?php bloginfo('template_url'); ?>/images/produtos-image-2.jpg" />
                        <div class="info-produto mt-15">
                            <div class="nome">Teste de Nome Um Pouco Maior Sim</div>
                            <div class="preco">
                                <span class="preco-de">R$10,00</span>
                                <br />
                                <span class="preco-por">R$9,99</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-25 item-produto">
                        <img src="<?php bloginfo('template_url'); ?>/images/produtos-image-3.jpg" />
                        <div class="info-produto mt-15">
                            <div class="nome">Teste de Nome Um Pouco Maior Sim</div>
                            <div class="preco">
                                <span class="preco-de">R$10,00</span>
                                <br />
                                <span class="preco-por">R$9,99</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-25 item-produto">
                        <img src="<?php bloginfo('template_url'); ?>/images/produtos-image-2.jpg" />
                        <div class="info-produto mt-15">
                            <div class="nome">Teste de Nome Um Pouco Maior Sim</div>
                            <div class="preco">
                                <span class="preco-de">R$10,00</span>
                                <br />
                                <span class="preco-por">R$9,99</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-25 item-produto">
                        <img src="<?php bloginfo('template_url'); ?>/images/produtos-image-3.jpg" />
                        <div class="info-produto mt-15">
                            <div class="nome">Teste de Nome Um Pouco Maior Sim</div>
                            <div class="preco">
                                <span class="preco-de">R$10,00</span>
                                <br />
                                <span class="preco-por">R$9,99</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-25 item-produto">
                        <img src="<?php bloginfo('template_url'); ?>/images/produtos-image-1.jpg" />
                        <div class="info-produto mt-15">
                            <div class="nome">Teste de Nome Um Pouco Maior Sim</div>
                            <div class="preco">
                                <span class="preco-de">R$10,00</span>
                                <br />
                                <span class="preco-por">R$9,99</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
?>
