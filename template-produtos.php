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
                    <?php
                    $args = array(
                           'orderby'      => 'name',
                           'show_count'   => 0,
                           'pad_counts'   => 0,
                           'hide_empty'   => 1,
                           'parent'       => 0,
                    );
                    $all_categories = getProductCategories($args);
                    foreach ($all_categories as $cat) {
                        $catName = $cat->name;
                        $catId   = $cat->term_id;

                        echo "<option value='$catId'>$catName</option>";

                        $args2 = array(
                                'orderby'      => 'name',
                                'show_count'   => 0,
                                'pad_counts'   => 0,
                                'hide_empty'   => 1,
                                'child_of'     => $catId,
                        );
                        $all_categories2 = getProductCategories($args2);
                        if(count($all_categories2) > 0){
                            foreach ($all_categories2 as $cat2) {
                                $catName2 = $cat2->name;
                                $catId2   = $cat2->term_id;

                                echo "<option value='$catId2'>&nbsp;- $catName2</option>";
                            }
                        }
                    }
                    ?>

                    <?php
                    /*
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
                    */
                    ?>
                </select>

                <?php
                $categoryId = (isset($_REQUEST["categoryId"])) ? $_REQUEST["categoryId"]: "";
                $styleAll   = ($categoryId == "") ? " font-weight: bold; ": "";
                ?>

                <ul id="categoria-produtos">
                    <li><a style="<?php echo $styleAll; ?>" href="javascript:;" onclick="execProdFilter('', $('#hddn-filters-order-by').val())">TODAS</a>

                    <?php
                    $args = array(
                           'orderby'      => 'name',
                           'show_count'   => 0,
                           'pad_counts'   => 0,
                           'hide_empty'   => 1,
                           'parent'       => 0,
                    );
                    $all_categories = getProductCategories($args);
                    foreach ($all_categories as $cat) {
                        $catName  = $cat->name;
                        $catId    = $cat->term_id;
                        $strStyle = ($categoryId == $catId) ? " font-weight: bold; ": "";

                        echo "<li><a style='$strStyle' href='javascript:;' onClick=\" execProdFilter('$catId', $('#hddn-filters-order-by').val()) \">$catName</a>";

                        $args2 = array(
                                'orderby'      => 'name',
                                'show_count'   => 0,
                                'pad_counts'   => 0,
                                'hide_empty'   => 1,
                                'child_of'     => $catId,
                        );
                        $all_categories2 = getProductCategories($args2);
                        if(count($all_categories2) > 0){
                            echo "<ul>";

                            foreach ($all_categories2 as $cat2) {
                                $catName2 = $cat2->name;
                                $catId2   = $cat2->term_id;
                                $strStyle = ($categoryId == $catId2) ? " font-weight: bold; ": "";

                                echo "<li><a style='$strStyle' href='javascript:;' onClick=\" execProdFilter('$catId2', $('#hddn-filters-order-by').val()) \">$catName2</a></li>";
                            }

                            echo "</ul>";
                        }

                        echo "</li>";
                    }
                    ?>

                    <?php
                    /*
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
                    */
                    ?>
                </ul>
            </div>
            <div class="col-md-9">
                <?php
                $orderBy     = (isset($_REQUEST["orderBy"])) ? $_REQUEST["orderBy"]: "";
                $arrProducts = getAllProducts($categoryId, "", "", $orderBy);

                echo "<input type='hidden' id='hddn-filters-category-id' value='$categoryId' />";
                echo "<input type='hidden' id='hddn-filters-order-by' value='$orderBy' />";
                ?>

                <div class="dv-titulo-coluna mb-20">
                    <?php echo count($arrProducts); ?> PRODUTO(S)

                    <ul id="filtros-produtos">
                        <li>
                            <?php
                            $strSlcEmpty = "";
                            $strSlcPriceDesc = "";
                            $strSlcPrice = "";

                            switch($orderBy){
                               case "priceDesc":
                                   $strSlcPriceDesc = " selected ";
                                   break;
                               case "price":
                                   $strSlcPrice = " selected ";
                                   break;
                            }
                            ?>

                            Ordenar por:
                            <select onchange="execProdFilter($('#hddn-filters-category-id').val(), '' + this.value)" id="ordenar-por">
                                <option <?php echo $strSlcEmpty; ?> value="">- Selecione</option>
                                <option <?php echo $strSlcPriceDesc; ?> value="priceDesc">Maior Preço</option>
                                <option <?php echo $strSlcPrice; ?> value="price">Menor Preço</option>
                            </select>
                        </li>
                        <?php #<li>1 | 2 | 3 | 4 | 5</li> ?>
                    </ul>
                </div>

                <div class="row" id="lista-produtos">
                    <?php
                    if( count($arrProducts) == 0 ){
                        echo "<p>Nenhum produto encontrado com os filtros selecionados =/</p>";
                    } else {
                        foreach($arrProducts as $Product){
                            ?>

                            <div class="col-md-4 mb-25 item-produto">
                                <a href="<?php echo $Product->getProductURL(); ?>"><img src="<?php echo $Product->getImageCatalogUrl(); ?>" /></a>
                                <div class="info-produto mt-15">
                                    <div class="nome"><?php echo $Product->getTitle(); ?></div>
                                    <div class="preco">
                                        <?php
                                        $precoDe  = ($Product->getSalePrice() > 0) ? $Product->getRegularPrice(): "";
                                        $precoPor = $Product->getPrice();

                                        if($precoDe > 0){
                                            ?>
                                            <span class="preco-de">R$<?php echo number_format($precoDe, 2, ",", "."); ?></span>
                                            <br />
                                            <?php
                                        }
                                        ?>
                                        
                                        <span class="preco-por">R$<?php echo number_format($precoPor, 2, ",", "."); ?></span>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>

                    <?php
                    /*
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
                    */
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
?>
