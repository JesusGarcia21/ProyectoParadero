<div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                <li class="nav-title">
                        Usuario
                    </li>
                    <li @click="menu=0" class="nav-item">
                    <a class="nav-link active" href="#"><i class="fas fa-question-circle"></i> Información</a>
                    </li>
                    <li @click="menu=8" class="nav-item">
                        <a class="nav-link active" href="#"><i class="fas fa-search"></i> Buscar</a>
                    </li>
                    <li class="nav-title">
                        Administrador
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="fas fa-car"></i> Vehiculos</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=1" class="nav-item">
                                <a class="nav-link" href="#"><i class="fas fa-list"></i> Lista de vehiculos</a>
                            </li>
                            <li @click="menu=2" class="nav-item">
                                <a class="nav-link" href="#"><i class="fas fa-shuttle-van"></i>Tipos de vehiculos</a>
                            </li>
                        </ul>
                    </li>
                    <li @click="menu=3" class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-hand-paper"></i> Paraderos </a>
                    </li>
                    <li @click="menu=4" class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-route"></i> Rutas </a>
                    </li>
                    <li @click="menu=5" class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-calendar-alt"></i> horarios </a>
                    </li>
                    <li @click="menu=6" class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-cogs"></i> Configuraciones </a>
                    </li>
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-pie-chart"></i> Lista 1</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=7" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-chart"></i> submenu 1</a>
                            </li>
                            <li @click="menu=8" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-chart"></i> submenu 2</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>