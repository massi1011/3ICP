from flask import Flask, render_template, request, redirect, url_for, flash, session
from flask_mysqldb import MySQL
from flask_wtf import FlaskForm
from wtforms import IntegerField, SubmitField
from wtforms.validators import DataRequired, NumberRange
import random

app = Flask(__name__)
app.config.from_object('config.Config')

mysql = MySQL(app)

class ConfigForm(FlaskForm):
    num_players = IntegerField('Nombre de joueurs', validators=[DataRequired(), NumberRange(min=1)])
    num_dice = IntegerField('Nombre de dés', validators=[DataRequired(), NumberRange(min=1)])
    num_games = IntegerField('Nombre de parties', validators=[DataRequired(), NumberRange(min=1)])
    wait_time = IntegerField('Temps d\'attente entre chaque partie (en secondes)', validators=[DataRequired(), NumberRange(min=0)])
    submit = SubmitField('Enregistrer')

@app.route('/')
def home():
    return redirect(url_for('admin'))

@app.route('/admin', methods=['GET', 'POST'])
def admin():
    form = ConfigForm()
    if form.validate_on_submit():
        num_players = form.num_players.data
        num_dice = form.num_dice.data
        num_games = form.num_games.data
        wait_time = form.wait_time.data
        
        cur = mysql.connection.cursor()
        cur.execute("""
            INSERT INTO configurations (num_players, num_dice, num_games, wait_time)
            VALUES (%s, %s, %s, %s)
        """, (num_players, num_dice, num_games, wait_time))
        mysql.connection.commit()
        cur.close()

        flash('Configuration enregistrée avec succès', 'success')
        return redirect(url_for('admin'))
    
    return render_template('admin.html', form=form)
@app.route('/quitter_et_arreter')
def quitter_et_arreter():
    return redirect("http://localhost:8888/3ICP/PFE/Acceuil.php")


@app.route('/start_game', methods=['GET'])
def start_game():
    
    cur = mysql.connection.cursor()
    cur.execute("SELECT * FROM configurations ORDER BY id DESC LIMIT 1")
    config = cur.fetchone()
    cur.close()

    if config is None:
        flash('Aucune configuration trouvée. Veuillez configurer une session et appuyez sur Enregistrer avant de commencer le jeu.', 'error')
        return redirect(url_for('admin'))

    session['config'] = config
    session['current_game'] = 1
    session['players_scores'] = [0] * config[1]  # Initialize scores for each player
    
    return redirect(url_for('play_game'))


@app.route('/play_game', methods=['GET', 'POST'])
def play_game():
    config = session.get('config')
    current_game = session.get('current_game')
    players_scores = session.get('players_scores')

    if request.method == 'POST':
        for player_id in range(config[1]):
            roll_result = sum(random.randint(1, 6) for _ in range(config[2])) #lancer de dés
            players_scores[player_id] += roll_result

            cur = mysql.connection.cursor()
            cur.execute("""
                INSERT INTO game_results (session_id, player_id, roll_result)
                VALUES (%s, %s, %s)
            """, (session.get('session_id', 1), player_id, roll_result))
            mysql.connection.commit()
            cur.close()
        
        session['current_game'] += 1

        if session['current_game'] > config[3]:
            return redirect(url_for('game_results'))
    
    return render_template('play_game.html', players_scores=players_scores, current_game=current_game, total_games=config[3])

@app.route('/game_results', methods=['GET'])
def game_results():
    players_scores = session.get('players_scores')
    return render_template('game_results.html', players_scores=players_scores)

@app.route('/check_config', methods=['GET'])
def check_config():
    cur = mysql.connection.cursor()
    cur.execute("SELECT COUNT(*) FROM configurations")
    config_exists = cur.fetchone()[0] > 0
    cur.close()
    return {'config_exists': config_exists}



@app.route('/pass_turn', methods=['POST'])
def pass_turn():
    # Insérer un score de 0 pour le joueur en cours dans la base de données
    # Supposons que vous avez une table 'scores' avec les colonnes 'player_id' et 'score'
    current_player_id = 1  # ID du joueur en cours (à récupérer depuis la session ou ailleurs)
    cursor = mysql.connection.cursor()
    cursor.execute("INSERT INTO game_results (player_id, roll_result) VALUES (%s, %s)", (current_player_id, 0))
    mysql.connection.commit()
    cursor.close()
    flash('Tour passé avec succès', 'success')
    return redirect(url_for('play_game'))

# Fonction pour récupérer le score du joueur en cours depuis la base de données
def fetch_current_player_score():
    # Supposons que vous avez une table 'scores' avec les colonnes 'player_id' et 'score'
    current_player_id = 1  # ID du joueur en cours (à récupérer depuis la session ou ailleurs)
    cursor = mysql.connection.cursor()
    cursor.execute("SELECT roll_result FROM game_results WHERE player_id = %s", (current_player_id,))
    current_player_score = cursor.fetchone()[0]  # Supposant qu'il n'y a qu'un seul score par joueur
    cursor.close()
    return current_player_score


if __name__ == '__main__':
    app.run(debug=True)
