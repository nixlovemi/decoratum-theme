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

                <select id="slc-categoria-produtos">
                    <optgroup label="Categoria 1">
                        <option value="Item 1">Item 1</option>
                        <option value="Item 2">Item 2</option>
                        <option value="Item 3">Item 3</option>
                        <option value="Item 4">Item 4</option>
                    </optgroup>

                    <optgroup label="Categoria 2">
                        <option value="Item 5">Item 5</option>
                        <option value="Item 6">Item 6</option>
                        <option value="Item 7">Item 7</option>
                    </optgroup>

                    <optgroup label="Categoria 3">
                        <option value="Item 8">Item 8</option>
                        <option value="Item 9">Item 9</option>
                        <option value="Item 10">Item 10</option>
                    </optgroup>
                </select>

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
                        <a href="<?php echo esc_url(home_url('/')).'produto'; ?>"><img src="<?php bloginfo('template_url'); ?>/images/produtos-image-1.jpg" /></a>
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
                        <a href="<?php echo esc_url(home_url('/')).'produto'; ?>"><img src="<?php bloginfo('template_url'); ?>/images/produtos-image-2.jpg" /></a>
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
                        <a href="<?php echo esc_url(home_url('/')).'produto'; ?>"><img src="<?php bloginfo('template_url'); ?>/images/produtos-image-3.jpg" /></a>
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
