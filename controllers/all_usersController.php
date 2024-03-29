<?php

namespace controllers;

use yasmf\HttpHelper;
use yasmf\View;

/**
 * yasmf - Yet Another Simple MVC Framework (For PHP)
 *     Copyright (C) 2019   Franck SILVESTRE
 *
 *     This program is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU Affero General Public License as published
 *     by the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU Affero General Public License for more details.
 *
 *     You should have received a copy of the GNU Affero General Public License
 *     along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

class all_usersController
{
    public function afficher($pdo) {
        $type = HttpHelper::getParam('type') ?: '' ;
		$lettre = HttpHelper::getParam('lettre') ?: '';
		
        $view = new View("views/index");
        $view->setVar('type',$type);
		$view->setVar('lettre', $lettre);
        return $view;
    }

}