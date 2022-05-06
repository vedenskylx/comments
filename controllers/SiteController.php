<?php

namespace app\controllers;

use app\models\Comment;
use app\models\CommentShort;
use yii\base\Exception;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index.tpl', ['comments' => Comment::find()->where(['parent_id' => null])->all()]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionComments($id): string
    {
        return $this->renderPartial('ul.tpl', ['comments' => Comment::find()->where(['parent_id' => $id])->all()]);
    }

    /**
     * @throws \yii\base\Exception
     */
    public function actionCreate(): string
    {
        $model = new Comment();
        $model->load(\Yii::$app->request->post(), '');

        if ($model->validate() && $model->save()) {
            return $this->renderPartial('list.tpl', ['comment' => $model]);
        } else {
            throw new Exception(current(current($model->getErrors())));
        }
    }

    /**
     * @throws \yii\db\StaleObjectException
     * @throws \yii\base\Exception
     */
    public function actionDelete($id): \yii\web\Response
    {
        $model = Comment::find()->where(['id' => $id])->one();

        if ($model) {
            $result = $model->delete();
            if ($parent = $model->parent) {
                if (count($parent->comments) > 0) {
                    $content = $this->renderPartial('ul.tpl', ['comments' => $parent->comments]);
                } else {
                    $content = false;
                }
            } else {
                $content = '';
            }

            return $this->asJson([
                'result'  => $result,
                'content' => $content
            ]);
        }

        throw new Exception('Comment not found!', 404);
    }

    /**
     * @throws \yii\db\StaleObjectException
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id): \yii\web\Response
    {
        $model = CommentShort::find()->where(['id' => $id])->one();

        if ($model) {
            $model->load(\Yii::$app->request->post(), '');

            if ($model->validate() && $result = $model->save()) {
                return $this->asJson([
                    'result'  => $result,
                    'comment' => $model
                ]);
            }
        }

        throw new Exception('Comment not found!', 404);
    }

}
